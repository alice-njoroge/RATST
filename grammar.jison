/* description: Relational Algebra parser. */

/* lexical grammar */
%lex
%%

\#[^\n]*                /* skip comments */
\%%[^\n]*               /* skip comments */
(\r\n|\r|\n)                   return 'NEWLINE';
\s+                   /* skip whitespace */
\"[^"]+\"         yytext = yytext.slice(1,-1); return 'STR'
\'[^']+\'           yytext = yytext.slice(1,-1); return 'STR'

"proj"                return "PROJ"
"PROJ"                return "PROJ"
"Proj"                return "PROJ"
"π"                   return "PROJ"
"proy"                return "PROJ"
"PROY"                return "PROJ"
"Proy"                return "PROJ"
"sel"                 return "SEL"
"Sel"                 return "SEL"
"SEL"                 return "SEL"
"σ"                   return "SEL"
"U"                   return "UNION"
"u"                   return "UNION"
"∪"                   return "UNION"
"|X|"                 return "NATURAL"
"|x|"                 return "NATURAL"
"⋈"                   return "NATURAL"
"X"                   return "PRODUCT"
"x"                   return "PRODUCT"
"×"                   return "PRODUCT"
"INT"                 return "INTERSECTION"
"int"                 return "INTERSECTION"
"Int"                 return "INTERSECTION"
"∩"                   return "INTERSECTION"
"true"                return "TRUE"
"false"               return "FALSE"
"Ren"                 return "REN"
"ren"                 return "REN"
"REN"                 return "REN"
"ρ"                   return "REN"
"OR"                  return 'OR'
"or"                  return 'OR'
"Or"                  return 'OR'
"AND"                 return 'AND'
"and"                 return 'AND'
"And"                 return 'AND'

[a-zA-Z][a-zA-Z0-9.]*    return 'IDENTIFIER'
[0-9]+("."[0-9]+)?\b  return 'NUMBER'
"*"                   return '*'
"/"                   return '/'
"-"                   return '-'
"+"                   return '+'
"^"                   return '^'
"!"                   return '!'
"%"                   return '%'
"("                   return '('
")"                   return ')'
","                   return "COMMA"
"["                   return '['
"]"                   return ']'
"|"                   return "OR"
"&"                   return "AND"
"<>"                  return '<>'
"<-"                  return '<-'
"<="                  return '<='
">="                  return '>='
">"                   return '>'
"<"                   return '<'
"="                   return '='
";"                   return ';'

<<EOF>>               return 'EOF'
.                     return 'INVALID'

/lex

/* operator associations and precedence */
/* TODO: Define subtraction precedence */
%left UNION
%left INTERSECTION
%left PRODUCT
%left NATURAL
%left OR
%left AND
%left '+' '-'
%left '*' '/'
%left '^'
%right '!'
%right '%'
%left UMINUS

%start ra_program

%% /* language grammar */

ra_program
    : ra_sentences EOF
        { return $1 }
    | ra_sentences sentence_separators EOF
        { return $1 }
    | sentence_separators ra_sentences sentence_separators EOF
        { return $2 }
    | sentence_separators ra_sentences EOF
        { return $2 }
    ;

ra_sentences
    : ra_sentence
        { $$ = new Array($1); }
    | ra_sentences sentence_separators ra_sentence
        { $1.push($3); $$ = $1; }
    ;

sentence_separators
    : sentence_separator
    | sentence_separators sentence_separator
    ;

sentence_separator
    : NEWLINE
    | ';'
    ;

ra_sentence 
    : IDENTIFIER '<-' ra_expression
        { $$ = { type: 'identifier', value: { id: $1, expression: $3.value} }; }
    | IDENTIFIER '(' field_list ')' '<-' ra_expression
        { $$ = { type: 'identifier', value: { id: $1, expression: $6.value, fields: $3 } }; }
    | ra_expression
        { $$ = { type: 'expression', value: $1 }; }
    ;

ra_expression
    : '(' ra_expression ')' { $$ = {id: yy.getNewId('GROUP'), value: $2.value }; }
    | tableName { $$ = {id: yy.getNewId('ID'), value: $1 }; }
    | projection { $$ = {id: yy.getNewId('PROJ'), value: $1 }; }
    | selection { $$ = {id: yy.getNewId('PROJ'), value: $1 }; }
    | union { $$ = {id: yy.getNewId('UNION'), value: $1 }; }
    | intersection { $$ = {id: yy.getNewId('UNION'), value: $1 }; }
    | product { $$ = {id: yy.getNewId('PROD'), value: $1 }; }
    | natural { $$ = {id: yy.getNewId('PROD'), value: $1 }; }
    | subtraction { $$ = {id: yy.getNewId('SUBS'), value: $1 }; }
    | rename { $$ = {id: yy.getNewId('REN'), value: $1 }; }
    ;

tableName
    : IDENTIFIER
        { $$ = yy.getSingleTable($1); }
    ;

projection
    : PROJ '[' field_list ']' '(' ra_expression ')'
        { $$ = yy.getProjection($6.value, $6.id, $3); }
    ;

rename
    : REN '[' field_list ']' '(' ra_expression ')'
        { $$ = yy.getRename($6.value, $6.id, $3); }
    ;

selection
    : SEL '[' bool_expression ']' '(' ra_expression ')'
        { $$ = yy.getSelection($6.value, $6.id, $3); }
    ;

union
    : ra_expression UNION ra_expression
        { $$ = yy.getUnion($1.value, $3.value); }
    ;

intersection
    : ra_expression INTERSECTION ra_expression
        { $$ = yy.getIntersection($1.value, $3.value); }
    ;

product
    : ra_expression PRODUCT ra_expression
        { $$ = yy.getProduct($1.value, $3.value); }
    ;

natural
    : ra_expression NATURAL ra_expression
        { $$ = yy.getNaturalJoin($1.value, $3.value); }
    ;

subtraction
    : ra_expression '-' ra_expression
        { $$ = yy.getSubtraction($1.value, $3.value); }
    ;

field_list
    : e {$$ = new Array($1)}
    | field_list COMMA e
        { 
            $1.push($3);
            $$ = $1;
        }
    ;

e
    : e '+' e
        { $$ = $1 + '+' + $3; }
    | e '-' e
        { $$ = $1 + '-' + $3; }
    | e '*' e
        { $$ = $1 + '*' + $3; }
    | e '/' e
        { $$ = $1 + '/' + $3; }
    | '-' e %prec UMINUS
        { $$ = '-' + $2;}
    | '(' e ')'
        { $$ =  '(' + $2 + ')'; }
    | NUMBER
        { $$ = Number(yytext); }
    | IDENTIFIER
    | STR
        { $$ = "'" + $1 + "'" }
    ;

b_e
    : e bool_operator e
        { $$ = yy.getBooleanOperation($1, $2, $3); }
    ;

bool_operator
    : '>'
    | '<'
    | '<='
    | '>='
    | '='
    | '<>'
    ;

bool_expression
    : factor
    | factor bool_op bool_expression
        { $$ = yy.getBooleanExpression($1, $2, $3); }
    ;

bool_op 
    : OR
    | AND
    ;

term
    : factor
    | factor AND factor
        { $$ = yy.getAnd($1, $3); }
    ;

factor
    : TRUE
    | FALSE
    | b_e
    | '!' factor
        { $$ = yy.getNot($2); }
    | '(' bool_expression ')'
        { $$ =  '(' + $2 + ')'; }
    ;