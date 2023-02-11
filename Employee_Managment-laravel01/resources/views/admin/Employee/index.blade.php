@extends('admin.template.base')

@section('title', 'Employee Registration')

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
              <h3 class="page-title"> Register Employees </h3>
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
                            <th>Name</th>
                            <th>Job Position</th>
                            <th>Employee Code</th>
                            <th>Father Name</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Personal Email</th>
                            <th>Company Email</th>
                            <th>Personal Mobile</th>
                            <th>Company Mobile</th>
                            <th>Current Address</th>
                            <th>Permanent Address</th>
                            <th>Pincode</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Country</th>
                            <th>Sallary</th>
                            <th>Bank Name</th>
                            <th>Account Number</th>
                            <th>IFSC Code</th>
                            <th>Created BY</th>
                            <th>Updated By</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @php $x=1; @endphp
                        @foreach($data as $employee)
                          <tr>
                            <td>{{$x++}}</td>
                            <td>{{$employee->first_name}} {{$employee->last_name}}</td>
                            <td>{{$employee->position}}</td>
                            <td>{{$employee->emp_code}}</td>
                            <td>{{$employee->father_name}}</td>
                            <td>{{$employee->DOB}}</td>
                            <td>{{$employee->gender}}</td>
                            <td>{{$employee->personal_email}}</td>
                            <td>{{$employee->company_email}}</td>
                            <td>{{$employee->personal_mobile}}</td>
                            <td>{{$employee->company_mobile}}</td>
                            <td>{{$employee->current_add}}</td>
                            <td>{{$employee->permanent_add}}</td>
                            <td>{{$employee->pincode}}</td>
                            <td>{{$employee->city}}</td>
                            <td>{{$employee->state}}</td>
                            <td>{{$employee->country}}</td>
                            <td>{{$employee->sallary}}</td>
                            <td>{{$employee->bank_name}}</td>
                            <td>{{$employee->acc_no}}</td>
                            <td>{{$employee->ifsc}}</td>
                            <td>{{$employee->created_by}}</td>
                            <td>{{$employee->updated_by}}</td>
                            <td>
                                @if($employee->usertype=='0')
                                    <label style="color: yellow">Employee</label>
                                @elseif($employee->usertype=='1')
                                    <label style="color: green">Admin</label>
                                @endif
                            </td>
                            <td>
                                @if($employee->status=='0')
                                    <label style="color: yellow">Pending</label>
                                @elseif($employee->status=='1')
                                    <label style="color: green">Active</label>
                                @else
                                    <label style="color: red">Inactive</label>
                                @endif
                            </td>
                            <th>
                                <a href="/admin/edit-employee-{{$employee->id}}"><i class="mdi mdi-table-edit" style="color: green;"></i></a>
                                <a href="/admin/delete-employee-{{$employee->id}}"><i class="mdi mdi-delete-forever" style="color: red;"></i></a>
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