@extends('layouts.app')

@section('title')
    カート一覧
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3 mb-3">
                <div class="card">
                    <div class="position-relative overflow-hidden">
                        <img class="card-img-top" src="../../public/images/sample.jpg">
                        <div class="position-absolute py-2 px-3"
                            style="left: 0; bottom: 20px; color: white; background-color: rgba(0, 0, 0, 0.70)">
                            <i class="fas fa-yen-sign"></i>
                            <span class="ml-1">ItemPrice</span>
                        </div>
                        <div class="position-absolute py-1 font-weight-bold d-flex justify-content-center align-items-end"
                            style="left: 0; top: 0; color: white; background-color: #EA352C; transform: translate(-50%,-50%) rotate(-45deg); width: 125px; height: 125px; font-size: 20px;">
                            <span>SOLD</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <small class="text-muted">PrimaryCategory / SecondaryCategory</small>
                        <h5 class="card-title">ItemName</h5>
                    </div>
                    <a href="#" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>
@endsection
