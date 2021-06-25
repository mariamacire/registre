<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Employe;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class EmployeController extends Controller
{
    // public function __construct(){
    //     $this->middleware('auth');

    //     // $this->middleware('auth')->only;
    // }

    public function index(){
        return view('admin.login');
    }
    public Function hom(){
        return view('admin.home');
    }

    public Function home(){
        return view('admin.index');
    }

    public function login(request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|alphaNum|min:3'
        ]);
        $user_data = array(
            'email' => $request->get('email'),
            'password' =>$request->get('password')
        );
        if(Auth::attempt($user_data)){

            return redirect('index');
        }else{
            return back()->withError('mail ou mot de passe incorrecte');
        }
    }
    
    public function logout(){
        Auth::logout();
        return view('admin.login');
    }

    public function form()
    {   
        return view('employe.employe');
    }

    public function store(Request $request)
    {    
        $rules = [
            'matricule' => 'required',
            'nom'=> 'required',
            'prenom'=> 'required',
            'email'=> 'required|email',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
         $employe = new Employe();

         $employe->matricule = $request->matricule;
         $employe->nom = $request->nom;
         $employe->prenom = $request->prenom;
         $employe->email = $request->email;
         

         $employe->save();
         
         return redirect(url('liste'))->withSuccess("l'employé est bien ajouté");
    }

    public function lister()
    {   
        $employes = Employe::all();
        return view('employe.liste')->with('employes',$employes);
    }

    public function editer($id)
    {
        $employe = Employe::find($id);
        return view('employe.modifier')->with('employe',$employe);
    }

    public function destroy($id)
    {
        $employe = Employe::where('id',$id);
        $employe->delete();
        return redirect(url('liste'))->withSuccess("l'employé est bien supprimé");;
    }

    public function update(Request $request, $id)
    { 
        
        $rules = [
            'matricule' => 'required',
            'nom'=> 'required',
            'prenom'=> 'required',
            'email'=> 'required|email',
        ];
        $validator = Validator::make($request->all(),$rules);
        
        if($validator->fails()){
           
            return back()->withErrors($validator) ->withInput();
        }
         $employe = Employe::find($id);

         $employe->matricule = $request->matricule;
         $employe->nom = $request->nom;
         $employe->prenom = $request->prenom;
         $employe->email = $request->email;
         //dd($employe);

         $employe->update();

         return redirect(url('liste'))->withSuccess("Les informations de l’employé ont bien été modifiées");
    }

}
