<?php

namespace App\Http\Controllers;

use App\Schema;
use Illuminate\Http\Request;

class SchemaController extends Controller
{
    /**
     * List the schemas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $schemas = Schema::all();
        return view('welcome', ['schemas' => $schemas]);
    }

    /**
     * display the step 1
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_schema_step_one_view()
    {
        return view('pages.schemas.create-schema-step-one');
    }

    /**
     * display the step 1
     * @param Schema $schema
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_schema_step_two_view(Schema $schema)
    {
        return view('pages.schemas.create-schema-step-two', ['schema' => $schema]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function process_step_one(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:schemas,name',
            'number_of_attributes' => 'required|numeric'
        ]);

        $schema = Schema::create([
            'name' => $request->input('name'),
            'number_of_attributes' => $request->input('number_of_attributes')
        ]);
        return redirect(route('add-schema-step-2', $schema->id));
    }

    /**
     * @param Request $request
     */
    public function process_step_two(Request $request)
    {
        $this->validate($request, [
            'attributes.*.name' => 'unique:schema_attributes,name'
        ]);
    }


    /**
     * remove the schema
     * @param Schema $schema
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Schema $schema)
    {
        $schema->delete();
        flash('schema deleted successfully')->success();
        return redirect()->back();
    }
}
