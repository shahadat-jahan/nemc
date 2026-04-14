<div class="container"
     style="box-sizing:border-box;width:90%;max-width:1140px;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;">
    <div class="row"
         style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;">
        <div class="col-md-12"
             style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;">
            <div class="text-center" style="box-sizing:border-box;text-align:center!important;">
                <img class="logo" src="{{asset('assets/global/img/nemc-logo.png')}}" alt="nemc logo"
                     style="box-sizing:border-box;vertical-align:middle;border-style:none;width:5rem;margin-bottom:5px;">
                <h4 class="font-bold text-uppercase"
                    style="box-sizing:border-box;font-size:1.5rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;text-transform:uppercase!important;">
                    North East Medical College, Sylhet</h4>
                <h6 class="font-bold"
                    style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
                    <span style="box-sizing:border-box;">Student Name : {{!isset($studentPayment->student) ? $studentPayment->student->full_name_en : 'n/a'}},</span>
                    <span style="box-sizing:border-box;">Student ID : {{!empty($studentPayment->student) ? $studentPayment->student->student_id : 'n/a'}},</span>
                    <span style="box-sizing:border-box;">Session : {{!empty($studentPayment->student->session) ? $studentPayment->student->session->title : 'n/a'}},</span>
                </h6>
            </div>
        </div>
        <div class="col-md-12"
             style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;">
            <h2 class="text-center" style="box-sizing:border-box;text-align:center!important;">Student Payment Info</h2>
            <div class="table-responsive"
                 style="box-sizing:border-box;display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;">
                <table class="table table-bordered"
                       style="box-sizing:border-box;border-collapse:collapse;width:100%;margin-bottom:1rem;color:#212529;border-width:0;">
                    <thead style="box-sizing:border-box;">
                    <tr style="box-sizing:border-box;">
                        <th scope="col"
                            style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                            Fee title
                        </th>
                        <th scope="col"
                            style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                            Paid Amount
                        </th>
                        <th scope="col"
                            style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                            Discount Amount
                        </th>
                        <th scope="col"
                            style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                            Payment Date
                        </th>
                        <th scope="col"
                            style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                            Remarks
                        </th>
                    </tr>
                    </thead>
                    <tbody style="box-sizing:border-box;">
                    <tr style="box-sizing:border-box;">
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentPayment->studentFee->title)? $studentPayment->studentFee->title : 'n/a'}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentPayment->amount)? $studentPayment->amount : 'n/a'}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentPayment->discount)? $studentPayment->discount : 'n/a'}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentPayment->payment_date)? $studentPayment->payment_date : 'n/a'}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentPayment->remarks)? $studentPayment->remarks : 'n/a'}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($studentFees) && !empty($studentFees))
            <div class="col-md-12"
                 style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;">
                <h2 class="text-center" style="box-sizing:border-box;text-align:center!important;">Student Fee Info</h2>
                <div class="table-responsive"
                     style="box-sizing:border-box;display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;">
                    <table class="table table-bordered"
                           style="box-sizing:border-box;border-collapse:collapse;width:100%;margin-bottom:1rem;color:#212529;border-width:0;">
                        <thead style="box-sizing:border-box;">
                        <tr style="box-sizing:border-box;">
                            <th scope="col"
                                style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                                Fee title
                            </th>
                            <th scope="col"
                                style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                                Payable Amount
                            </th>
                            <th scope="col"
                                style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                                Paid Amount
                            </th>
                            <th scope="col"
                                style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                                Remarks
                            </th>
                        </tr>
                        </thead>
                        <tbody style="box-sizing:border-box;">
                        <tr style="box-sizing:border-box;">
                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentPayment->studentFee->title)? $studentPayment->studentFee->title : 'n/a'}}</td>
                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentFees->payable_amount)? $studentFees->payable_amount : 'n/a'}}</td>
                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentFees->paid_amount)? $studentFees->paid_amount : 'n/a'}}</td>
                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentFees->remarks)? $studentFees->remarks : 'n/a'}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if(isset($studentFeeDetails) && !empty($studentFeeDetails))
            <div class="col-md-12"
                 style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;">
                <h2 class="text-center" style="box-sizing:border-box;text-align:center!important;">Student Fee Details
                    Info</h2>
                <div class="table-responsive"
                     style="box-sizing:border-box;display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;">
                    <table class="table table-bordered"
                           style="box-sizing:border-box;border-collapse:collapse;width:100%;margin-bottom:1rem;color:#212529;border-width:0;">
                        <thead style="box-sizing:border-box;">
                        <tr style="box-sizing:border-box;">
                            <th scope="col"
                                style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                                Fee title
                            </th>
                            <th scope="col"
                                style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                                Payment Type
                            </th>
                            <th scope="col"
                                style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                                Payable Amount
                            </th>
                            <th scope="col"
                                style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                                Last Date of Payment
                            </th>
                            <th scope="col"
                                style="box-sizing:border-box;text-align:inherit;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;vertical-align:bottom;border-bottom-width:2px;border-bottom-style:solid;border-bottom-color:#dee2e6;">
                                Status
                            </th>
                        </tr>
                        </thead>
                        <tbody style="box-sizing:border-box;">
                        @foreach($studentFeeDetails as $studentFeeDetail)
                            <tr style="box-sizing:border-box;">
                                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentFeeDetail->fee->title)? $studentFeeDetail->fee->title : 'n/a'}}</td>
                                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentFeeDetail->paymentType->title)? $studentFeeDetail->paymentType->title : 'n/a'}}</td>
                                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentFeeDetail->payable_amount)? $studentFeeDetail->payable_amount : 'n/a'}}</td>
                                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">{{!empty($studentFeeDetail->last_date_of_payment)? $studentFeeDetail->last_date_of_payment : 'n/a'}}</td>
                                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#dee2e6;padding-top:.75rem;padding-bottom:.75rem;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#dee2e6;">
                                    @if($studentFeeDetail->status == 1)
                                        Paid
                                    @elseif($studentFeeDetail->status == 2)
                                        Partially Paid
                                    @else
                                        Not Paid
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
