<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\Title as Title;

class ClientController extends Controller
{
    //
    public function __construct(Title $titles, Client $client)
    {
        $this->titles = $titles->all();
        $this->client = $client;
    }

    public function di()
    {
        dd($this->titles);
    }

    public function index()
    {
        // $data = [];
        // $obj = new \stdClass;
        // $obj->id = 1;
        // $obj->title = 'mr';
        // $obj->name = 'john';
        // $obj->last_name = 'doe';
        // $obj->email = 'johndee@gmail.com';
        // $data['clients'][] = $obj;
        // $obj = new \stdClass;
        // $obj->id = 2;
        // $obj->title = 'ms';
        // $obj->name = 'jane';
        // $obj->last_name = 'doe';
        // $obj->email = 'janedee@gmail.com';
        // $data['clients'][] = $obj;
        $data = [];
        $data['clients'] = $this->client->all();
        return view('client/index', $data);
    }

    public function newClient(Request $request, Client $client)
    {
        $data = [];

        $data['title'] = $request->input('title');
        $data['name'] = $request->input('name');
        $data['last_name'] = $request->input('last_name');
        $data['address'] = $request->input('address');
        $data['zip_code'] = $request->input('zip_code');
        $data['city'] = $request->input('city');
        $data['state'] = $request->input('state');
        $data['email'] = $request->input('email');

        if($request->isMethod('post')){
            $this->validate($request,[
                'title'=> 'required',
                'name'=> 'required|min:5',
                'last_name'=> 'required',
                'address'=> 'required',
                'zip_code'=> 'required',
                'city'=> 'required',
                'state'=> 'required',
                'email'=> 'required',
            ]);
            $client->insert($data);
            return redirect('clients');
        }
        $data['titles'] = $this->titles;
        $data['modify'] = 0;

        return view('client.form', $data);
    }

    public function create()
    {
        return view('client/create');
    }

    public function show($client_id, Request $request)
    {
        $data = [];
        $data['titles'] = $this->titles;
        $data['modify'] = 1;
        $data['client'] = $client_id;
        $client_data = $this->client->find($client_id);
        $data['title'] = $client_data->title;
        $data['name'] = $client_data->name;
        $data['last_name'] = $client_data->last_name;
        $data['address'] = $client_data->address;
        $data['zip_code'] = $client_data->zip_code;
        $data['email'] = $client_data->email;
        $data['state'] = $client_data->state;
        $data['city'] = $client_data->city;
        $request->session()->put('last_updated', $client_data->name . '' . $client_data->last_name);
        return view('client.form', $data);
    }

    public function modify(Request $request, $client_id) {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required',
                'name' => 'required|min:5',
                'last_name' => 'required',
                'address' => 'required',
                'zip_code' => 'required',
                'city' => 'required',
                'state' => 'required',
                'email' => 'required',
            ]);
            $client_data = $this->client->find($client_id);
            $client_data->title = $request->input('title');
            $client_data->name = $request->input('name');
            $client_data->last_name = $request->input('last_name');
            $client_data->address = $request->input('address');
            $client_data->zip_code = $request->input('zip_code');
            $client_data->city = $request->input('city');
            $client_data->state = $request->input('state');
            $client_data->email = $request->input('email');
            $client_data->save();
            return redirect('clients');
        }
    }
}
