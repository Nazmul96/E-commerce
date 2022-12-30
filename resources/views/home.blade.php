@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            @include('user.sidebar')
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Dashboard') }}
                    <a href="{{route('write.review')}}" style="float:right;"><i class="fas fa-pencil-alt"></i> Write a review</a>
                </div>

                <div class="card-body">
                   <div class="row">
                       <div class="col-lg-3">
                           <a href=""> 
                             <div class="card" >
                               <div class="card-body">
                                 <h5 class="card-title text-success text-center">Total Order</h5>
                                 <h6 class="card-subtitle mb-2 text-muted text-center">{{ 0 }}</h6>
                               </div>
                             </div>
                           </a>
                       </div>
                       <div class="col-lg-3">
                           <a href=""> 
                             <div class="card" >
                               <div class="card-body">
                                 <h5 class="card-title text-success text-center">Complete Order</h5>
                                 <h6 class="card-subtitle mb-2 text-muted text-center">{{ 0 }}</h6>
                               </div>
                             </div>
                           </a>
                       </div>
                       <div class="col-lg-3">
                           <a href=""> 
                             <div class="card" >
                               <div class="card-body">
                                 <h5 class="card-title text-danger text-center">Cancel Order</h5>
                                 <h6 class="card-subtitle mb-2 text-muted text-center">{{ 0 }}</h6>
                               </div>
                             </div>
                           </a>
                       </div>
                       <div class="col-lg-3">
                          <a href=""> 
                            <div class="card" >
                              <div class="card-body">
                                <h5 class="card-title text-warning text-center">Return Order</h5>
                                <h6 class="card-subtitle mb-2 text-muted text-center">{{ 0 }}</h6>
                              </div>
                            </div>
                          </a>
                       </div>
                   </div><br>
                   <h4>Recent Order</h4>
                   <div>
                       <table class="table">
                         <thead>
                           <tr>
                             <th scope="col">OrderId</th>
                             <th scope="col">Date</th>
                             <th scope="col">Total</th>
                             <th scope="col">Payment Type</th>
                             <th scope="col">Status</th>
                           </tr>
                         </thead>
                         <tbody>
                         
                         </tbody>
                       </table>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div><hr>
@endsection
