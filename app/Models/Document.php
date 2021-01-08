<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Document extends Model
{
    use HasFactory;

    protected $table = 'meeting_documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_path',
        'table_id',
        'table_name',
    ];

    static function insert($request, $tableName, $table, $folderName){
        if($request->hasFile('file')){
            foreach($request->file as $key => $value){

                $ext = $request->file[$key]->getClientOriginalExtension();
                $filename = ucwords($request->file[$key]->getClientOriginalName()) . '.' . $ext;

                $path = $request->file[$key]->storeAs(
                    Auth::user()->username.'-'.$folderName, $filename, 'public'
                );

                Document::create([
                    'file_path' => $path,
                    'table_id' => $table->id,
                    'table_name' => $tableName,
                ]);
            }
        }
    }

    static function updateData($request, $tableName, $table, $folderName){
        $exploadedDocumentIds = explode(',', $request->documentIds);

        foreach($exploadedDocumentIds as $key){
            Document::where([['id', $key],['table_id', $table->id],['table_name',$tableName]])->delete();
        }

        Document::insert($request, $tableName, $table, $folderName);
    }
}
