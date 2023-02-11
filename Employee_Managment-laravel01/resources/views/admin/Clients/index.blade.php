@extends('admin.template.base')

@section('title', 'All Register Clients ')

@section('styles')
    <style>
        /* body{
            color: red !important;
        } */
    </style>
@endsection

@section('content')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">All Register Clients </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <!-- <li class="breadcrumb-item"><a href="#">Tables</a></li> -->
                  <!-- <li class="breadcrumb-item active" aria-current="page">Basic tables</li> -->
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <!-- <h4 class="card-title">Hoverable Table</h4>
                    <p class="card-description"> Add class <code>.table-hover</code> -->
                    </p>
                    <div class="table-responsive">
                      <table class="table table-hover" id="datatablesSimple">
                        <thead>
                          <tr>
                            <th>Sr No.</th>
                            <th>Client Name</th>
                            <th>Contact Email</th>
                            <th>Contact Mobile</th>
                            <th>Company Name</th>
                            <th>Company Logo</th>
                            <th>Start Date</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @php $x=1; @endphp
                        @foreach($clients as $client)
                          <tr>
                            <td>{{$x++}}</td>
                            <td>{{$client->client_name}}</td>
                            <td>{{$client->contact_email}}</td>
                            <td>{{$client->contact_mobile}}</td>
                            <td>{{$client->company_name}}</td>
                            <td>
                              @if(!empty($client->company_logo))
                                  <img class="img-lg rounded-circle" src="../images/clients/{{$client->company_logo}}" alt="company logo">
                              @else
                                  <img class="img-lg rounded-circle" src="../images/clients/default/client1-default.jpg" alt="company logo">
                              @endif
                            </td>
                            <td>{{$client->start_date}}</td>
                            <td>{{$client->created_by}}</td>
                            <td>{{$client->updated_by}}</td>
                            <th>
                                <a href="/admin/edit-client-{{$client->id}}"><i class="mdi mdi-table-edit" style="color: green;"></i></a>
                                <a href="/admin/delete-client-{{$client->id}}"><i class="mdi mdi-delete-forever" style="color: red;"></i></a>
                            </th>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
@endsection

@section('scripts')
<script src="../../js/datatables-simple-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection