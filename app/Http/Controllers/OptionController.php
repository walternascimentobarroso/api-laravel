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
        return Option::get();
    }
    public function update(Request $request, $id)
    {
        $option = Option::find($id);

        if (!$option) {
            return response()->json([
                'message' => 'Opção não encontrada.'
            ], 404);
        }

        $option->text = $request->input('text');
        $option->correct = $request->input('correct');
        $option->save();

        return response()->json([
            'message' => 'Opção atualizada com sucesso.',
            'data' => $option
        ], 200);
    }

    public function store(Request $request)
    {
        $question = Question::find($request->input('question_id'));

        if (!$question) {
            return response()->json([
                'message' => 'Questão não encontrada.'
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

    public function show(Option $option)
    {
        return response()->json($option);
    }

    public function destroy($id)
    {
        $option = Option::find($id);

        if (!$option) {
            return response()->json([
                'message' => 'Opção não encontrada.'
            ], 404);
        }

        $option->delete();

        return response()->json([
            'message' => 'Opção excluída com sucesso.'
        ], 200);
    }
}
