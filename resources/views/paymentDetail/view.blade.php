@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-info-circle pr-2"></i>Payment Detail</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ url('admin/payment_detail') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-list-alt pr-2"></i>Payment Details</a>
            </div>
        </div>

       <div class="m-portlet__body">
           <div class="m-section__content">
               <div class="row">
                   <div class="col-md-12">
                       detail
                   </div>
               </div>
           </div>
       </div>
    </div>
@endsection

