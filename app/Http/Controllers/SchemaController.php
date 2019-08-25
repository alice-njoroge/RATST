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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function process_step_two(Request $request)
    {
        $this->validate($request, [
            'attributes.*.name' => 'required|unique:schema_attributes,name',
            'attributes.*.type' => 'required|string',
        ]);
        $attributes = collect($request->input('attributes'));
        $names = $attributes->map(function ($item, $key) {
            return $item['name'];
        });
        $unique_names = array_unique($names->toArray()); // get unique names
        $duplicate_keys_assoc = array_diff_assoc($names->toArray(), $unique_names); // differentiate main array from the unique array
        $duplicate_names = array_values($duplicate_keys_assoc); // remove the names from the associative array
        if (sizeof($duplicate_names) > 0) { // message formatting using commas where duplicates are more than one
            $message = '';
            foreach ($duplicate_names as $key => $value) {
                if ($key == 0) {
                    $message = $value;
                } else {
                    $message = $message . ',' . $value;
                }
            }
            $message = $message . ' are duplicates. Please fix this';
            flash($message)->error();
            return redirect()->back()->withInput($request->all());
        }
        foreach ($request->input('attributes')) {
        }
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
