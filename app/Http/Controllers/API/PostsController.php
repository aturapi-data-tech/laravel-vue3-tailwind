<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index()
    {
        $posts=Posts::all();
        return PostsController::aturRapiResponse($posts);
        
    }

    public function add(Request $request)
    {

        $input=$request->all();
        $validator = ['name' => 'required','description' => 'required'];
        $editValidatorErrors = ['name.required' => 'nama Tidak Boleh Kosong','description.required' => 'description Tidak Boleh Kosong'];
        $aturRapivalidator = Validator::make($input,$validator,$editValidatorErrors);
        
        if ($aturRapivalidator->fails()) {
                $erros = $aturRapivalidator->errors()->add('errorMessage','isi data sesuai dgn format yang sudah ditentukan.');
                $aturRapiResponseErros = [
                   'code'=>'400',
                   'message'=>'HTTP_BAD_REQUEST',
                   'errors'=>$erros
                        ];
                return response()->json($aturRapiResponseErros,Response::HTTP_BAD_REQUEST);
                }
                else{
                 
                 Posts::create($input);
                $aturRapiResponse = [
                    'code'=>'200',
                    'message'=>'HTTP_OK',
                    'success'=>$input                    
                ];
                return response()->json($aturRapiResponse,Response::HTTP_OK);
    }
    }
        

    public function edit($id)
    {
        $posts = Posts::find($id);
        return PostsController::aturRapiResponse($posts);
    }

    public function update($id, Request $request)
    {
        $input=$request->all();
        $validator = ['name' => 'required','description' => 'required'];
        $editValidatorErrors = ['name.required' => 'nama Tidak Boleh Kosong','description.required' => 'description Tidak Boleh Kosong'];
        $aturRapivalidator = Validator::make($input,$validator,$editValidatorErrors);
        $posts = Posts::find($id);

        if ($aturRapivalidator->fails()) {
                $erros = $aturRapivalidator->errors()->add('errorMessage','isi data sesuai dgn format yang sudah ditentukan.');
                $aturRapiResponseErros = [
                   'code'=>'400',
                   'message'=>'HTTP_BAD_REQUEST',
                   'errors'=>$erros
                        ];
                return response()->json($aturRapiResponseErros,Response::HTTP_BAD_REQUEST);
                } 
                else if (empty($posts)){
                    $aturRapiResponseErros = [
                        'code'=>'404',
                        'message'=>'HTTP_NOT_FOUND',
                        'errors'=>['errorMessage'=>'Data tidak ditemukan.']
                    ];
                    return response()->json($aturRapiResponseErros,Response::HTTP_NOT_FOUND);
                }
                else {
            
                    $input = $request->all();
                                
                                $posts->update($input);
                                $aturRapiResponse = [
                                    'code'=>'200',
                                    'message'=>'HTTP_OK',
                                    'success'=>'Data berhasil di update.'
                                    
                                ];
                                return response()->json($aturRapiResponse,Response::HTTP_OK);
                            }
    }



    public function delete($id)
    {
        $posts = Posts::find($id);

        if (empty($posts)){
            $aturRapiResponseErros = [
                'code'=>'404',
                'message'=>'HTTP_NOT_FOUND',
                'errors'=>['errorMessage'=>'Data tidak ditemukan.']
            ];
            return response()->json($aturRapiResponseErros,Response::HTTP_NOT_FOUND);
        }
        else {
    
                                    
            $posts->delete();
                        $aturRapiResponse = [
                            'code'=>'200',
                            'message'=>'HTTP_OK',
                            'success'=>'Data berhasil di delete.'
                            
                        ];
                        return response()->json($aturRapiResponse,Response::HTTP_OK);
                    }
        
        

    }


    public function aturRapiResponse($cekAturRapiResponse){

        if ( !empty($cekAturRapiResponse)){            

            $aturRapiResponse = [
                'code'=>'200',
                'message'=>'HTTP_OK',
                'data'=>$cekAturRapiResponse
            ];
            return response()->json($aturRapiResponse,Response::HTTP_OK);
            
        } else
        {
            $aturRapiResponse = [
                'code'=>'404',
                'message'=>'HTTP_NOT_FOUND',
                'errors'=>['errorMessage'=>'Data tidak ditemukan.']
            ];
            return response()->json($aturRapiResponse,Response::HTTP_NOT_FOUND);
        }
    }


    


}

