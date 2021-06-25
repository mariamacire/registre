@extends('admin.index')
@section('content')

    <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <p>Liste des employés</p>
                    </div>
                    <div class="col-6">
                        <p style="text-align: right">
                            <a class="btn btn-primary" href="{{url('form-employe')}}">Créer un employé</a>
                        </p>
                    </div>
                </div>              
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">

                    @if(\Session::has('success'))                                  
                        <div class="alert alert-success" role="alert">
                        {{ \Session::get('success') }}
                        </div>
                    @endif
                    <table class="table caption-top">
                        <!-- <caption>List of users</caption> -->
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>matricule</th>
                                <th>nom</th>
                                <th>prenom</th>
                                <th>email</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employes as $employe)
                               <tr>
                                    <th scope="row"></th>
                                    <td>{{$employe->matricule}}</td>
                                    <td>{{$employe->nom}}</td>
                                    <td>{{$employe->prenom}}</td>
                                    <td>{{$employe->email}}</td>
                                    <td>
                                        <a href="{{url('modifier',$employe->id)}}"><i class="fa fa-edit"></i></a>
                                        <a style="color: red" href="{{url('delete',$employe->id)}}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
     </section>

@endsection