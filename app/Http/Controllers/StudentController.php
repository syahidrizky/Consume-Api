<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Libraries\BaseApi;

class StudentController extends Controller
{
    public function index()
    {
        // $data = (new BaseApi)->index('api/students');
        // $students = $data->json();
        // return view('students.index')->with('students', $students['data']);

        $data = (new BaseApi)->index('/api/students');
        $students = $data->json('data');

        for ($i=0; $i < count($students); $i++) {
            $students[$i]['image_path'] = env('API_HOST') . 'storage/' . $students[$i]['image'];
        }

        return view('students.index')->with('students' , $students);
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $upload = [
            'nis' => $request->nis,
            'nama' => $request->nama,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ];
            
        $baseApi = new BaseApi;
        $response = $baseApi->create('/api/students/store', $upload);
        return redirect('/students');
    }

    public function show($id)
    {
        $data = (new BaseApi)->detail('/api/students', $id);
        $students = $data->json();
        return view('students.show')->with('students', $students['data']);
    }

    public function edit($id)
    {
        $data = (new BaseApi)->detail('/api/students', $id);
        $students = $data->json();
        return view('students.update')->with('students', $students['data']);
    }

    public function update(Request $request, $id)
    {
        $payload = [
            'nis' => $request->nis,
            'nama' => $request->nama,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ];

        $baseApi = new BaseApi;
        $response = $baseApi->update('/api/students/update', $id, $payload);
        return redirect('/students');
    }

    public function destroy(Request $request, $id)
    {
        $baseApi = new BaseApi;
        $response = $baseApi->delete('/api/students/delete', $id);
        return redirect('/students');
    }
}
