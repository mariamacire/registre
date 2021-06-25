@extends('admin.index')
@section('content')

    <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <p>Modifier les informations de l'employé</p>
                    </div>
                </div>              
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <form class="form-group" action="{{ url('update', $employe->id) }}" method="post">
                        {{ csrf_field()}}
                        <div class="form-goup">
                            <label>Matricule</label>
                            <input type="text" value="{{$employe->matricule}}" class="form-control @error('matricule') is-invalid @enderror" name="matricule">
                            @error('matricule')
                                <div class="invalid-feedback"> 
                                    {{$errors->first('matricule')}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-goup">
                            <label >Nom</label>
                            <input type="text" value="{{$employe->nom}}" class="form-control @error('nom') is-invalid @enderror" name="nom" >
                            @error('nom')
                                <div class="invalid-feedback"> 
                                    {{$errors->first('nom')}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-goup">
                            <label>Prenom</label>
                            <input type="text" value="{{$employe->prenom}}" class="form-control @error('prenom') is-invalid @enderror" name="prenom">
                            @error('prenom')
                                <div class="invalid-feedback"> 
                                    {{$errors->first('prenom')}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-goup">
                            <label >E-mail</label>
                            <input type="text" value="{{$employe->email}}" class="form-control @error('email') is-invalid @enderror" name="email" >
                            @error('email')
                                <div class="invalid-feedback"> 
                                    {{$errors->first('email')}}
                                </div>
                            @enderror
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>

    
@endsection