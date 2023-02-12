<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Option::paginate(10);
        return response()->json($options);
    }

    public function store(Request $request)
    {
        $question = Question::find($request->input('question_id'));

        if (!$question) {
            return response()->json([
                'message' => 'Question not found.'
            ], 404);
        }

        $option = new Option();
        $option->text = $request->input('text');
        $option->correct = $request->input('correct');
        $question->options()->save($option);

        return response()->json([
            'message' => 'Opção cadastrada com sucesso.',
            'data' => $option
        ], 201);
    }

    public function update(Option $option, Request $request)
    {
        $option->update($request->all());

        return response()->json($option, 201);
    }



    public function show(Option $option)
    {
        return response()->json($option);
    }

    public function destroy(Option $option)
    {
        $option->delete();

        return response()->json('Option deleted!');
    }
}
