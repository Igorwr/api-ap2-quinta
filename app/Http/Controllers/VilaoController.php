<?php

namespace App\Http\Controllers;
use App\Responses\JsonResponse;
use App\Models\Vilao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VilaoController extends Controller
{
    public function criar(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nome' => 'required|string|max:200',
            'universo'=> 'required|string|max:100',
            'poder'=> 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ],422);
        }
        $vilao = Vilao::create($request->all());
        return JsonResponse::sucess('Vilão criado com sucesso', $vilao);
    }

    public function listar()
    {
        $vilao = Vilao::all();
        return JsonResponse::sucess(data: $vilao);
    }

    public function editar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:200',
            'universo'=> 'required|string|max:100',
            'poder'=> 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $vilao = Vilao::findOrFail($id);
        $vilao->update($request->all());
        
        return JsonResponse::sucess('Vilão alterado com sucesso', $vilao);
    }

    public function excluir(Request $request, int $id)
    {
        $vilao = Vilao::findOrFail($id);
        $vilao->delete();
        
        return JsonResponse::sucess('Vilão deletado com sucesso');
    }

    public function exibirPeloId(Request $request, int $id)
    {
        $vilao = Vilao::findOrFail($id);
        return JsonResponse::sucess('Vilão Encontrado', $vilao);
    }
}
