<?php


namespace App\Http\Controllers;
use App\Responses\JsonResponse;
use App\Models\Heroi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class HeroiController extends Controller
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
        $heroi = Heroi::create($request->all());
        return JsonResponse::sucess('Heroi criado com sucesso', $heroi);
    }

    public function listar()
    {
        $heroi = Heroi::all();
        return JsonResponse::sucess(data: $heroi);
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

        $heroi = Heroi::findOrFail($id);
        $heroi->update($request->all());
        
        return JsonResponse::sucess('Heroi alterado com sucesso', $heroi);
    }

    public function excluir(Request $request, int $id)
    {
        $heroi = heroi::findOrFail($id);
        $heroi->delete();
        
        return JsonResponse::sucess('Heroi deletado com sucesso');
    }

    public function exibirPeloId(Request $request, int $id)
    {
        $heroi = Heroi::findOrFail($id);
        return JsonResponse::sucess('Heroi Encontrado', $heroi);
    }
}
