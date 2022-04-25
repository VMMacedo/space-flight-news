<?php

namespace App\Http\Controllers;

use App\Models\v1\article;
use App\Http\Requests\StorearticleRequest;
use App\Http\Requests\UpdatearticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    /**Construtor para a Model Article */
    public function __construct(article $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**Variavel de pesquisa */
        $search = $request->search == null ? null : $request->search;
        /**Variavel paginate */
        $per_page = $request->per_page == null ? 10 : $request->per_page;
        /**Variavel OrderBy */
        $orderByKey = $request->orderByKey == null ? 'id' : $request->orderByKey;
        $orderByVal = $request->orderByVal == null ? 'desc' : $request->orderByVal;

        $result = $this->model->getDados($search, $orderByKey, $orderByVal, $per_page);

        return $result;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = $request->all();
        /**Validação*/
        $request->validate($this->model->rules(), $this->model->feedback());

        /**Metodo de inserção no banco após validação */
        $store = $this->model->create($dados);

        $response =  array(
            'success' => [
                $store
            ]
        );

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($result = $this->model->select()->find($id)) {
            $status = 'success';
            $codeReturn = 200;
            $show = $result;
        } else {
            $codeReturn = 404;
            $status = 'errors';
            $show =  "Item não encontrado";
        }

        $response =  array(
            $status => [
                $show
            ]
        );

        return response()->json($response, $codeReturn);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatearticleRequest  $request
     * @param  \App\Models\v1\article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = $this->model->find($id);

        if ($request->method() === 'PATCH') {
            /**
             * Função para executar quando o metodo for PATCH
             */
            $arrayRegrasDinamicas = array();
            foreach ($request->all() as $key => $value) {
                $data[$key] = $value;
                foreach ($this->model->rules() as $input => $regra) {
                    /**
                     * Percorre as regras de validação para ser aplicada apenas 
                     * a que for encontrada
                     */
                    if ($input === $key) {
                        $arrayRegrasDinamicas[$input] = $regra;
                    }
                }
                $request->validate($arrayRegrasDinamicas, $this->model->feedback());
            }
        } else {
            /**
             * Função para executar quando o metodo for PUT
             */
            $request->validate($this->model->rules(), $this->model->feedback());

            $data = $request->all();
        }

        /**
         * Verifica se existe registro
         */
        if (!$item) {
            $status = 'errors';
            $codeReturn = 404;
            $show = "Item não encontrado";
        } else if (!$update = $item->update($data)) {
            $status = 'errors';
            $codeReturn = 500;
            $show = "Erro ao atualizar item";
        } else {
            /**Get dados intem atualizado */
            $item = $this->model->find($id);

            $status = 'success';
            $codeReturn = 201;
            $show = $item;
        }


        $response =  array(
            $status => [
                $show
            ]
        );
        return response()->json($response, $codeReturn);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\v1\article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**Deletar item  */
        if (!$item = $this->model->find($id)) {
            $status = 'errors';
            $codeReturn = 404;
            $show = "Item não encontrado";
        }else if (!$delete = $item->delete()) {
            $status = 'errors';
            $codeReturn = 404;
            $show = "Não foi possível deletar item";
        } else {
            $status = 'success';
            $codeReturn = 200;
            $show = "Item excluído";
        }
        /**ITEM DELETADO */
        $response =  array(
            $status => [
                $show
            ]
        );
        return response()->json($response, $codeReturn);
    }
}
