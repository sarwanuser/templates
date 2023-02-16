@extends('admin.template.base')

@section('title', 'All Projects ')

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
              <h3 class="page-title">All Projects </h3>
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
                            <th>Project Name</th>
                            <th>Project URL</th>
                            <th>Project Dev URL</th>
                            <th>Client Name</th>
                            <th>Working Employees</th>
                            <th>Project Budget</th>
                            <th>Created Date</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Timeline</th>
                            <th>Project Status</th>
                            <th>Status Change Date</th>
                            <th>Payment Status</th>
                            <th>Target Status</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @php $x=1; @endphp
                        @foreach($projects as $project)
                          <tr>
                            <td>{{$x++}}</td>
                            <td>{{$project->project_name}}</td>
                            <td>{{$project->project_url}}</td>
                            <td>{{$project->project_dev_url}}</td>
                            <td>{{$project->client_name}}</td>
                            <td>{{$project->working_emp}}</td>
                            <td>{{$project->budget}}</td>
                            <td>{{date("d-m-Y", strtotime($project->created_date))}}</td>
                            <td>@if(!empty($project->start_date)){{date("d-m-Y", strtotime($project->start_date))}} @endif</td>
                            <td>@if(!empty($project->end_date)){{date("d-m-Y", strtotime($project->end_date))}} @endif</td>
                            <td>{{$project->timeline}} days</td>
                            <td>
                              @if($project->status=='ST')
                                Started
                              @elseif($project->status=='PL')
                                Planning
                              @elseif($project->status=='DV')
                                Developmemt
                              @elseif($project->status=='SG')
                                Staging
                              @elseif($project->status=='TS')
                                Testing
                              @elseif($project->status=='LV')
                                Live
                              @elseif($project->status=='DN')
                                Done
                              @elseif($project->status=='RW')
                                Re-Work
                              @elseif($project->status=='RT')
                                Re-Testing
                              @elseif($project->status=='PR')
                                Process
                              @endif

                            </td>
                            <td>@if(!empty($project->status_change_date)){{date("d-m-Y", strtotime($project->status_change_date))}} @endif</td>
                            <td>
                              @if($project->payment_status=='PN')
                                Pending
                              @elseif($project->payment_status=='PR')
                                Partial
                              @elseif($project->payment_status=='DU')
                                Due
                              @elseif($project->payment_status=='OD')
                                Over-Due
                              @elseif($project->payment_status=='DN')
                                Done  
                              @endif
                            </td>
                            <td>
                              @if($project->target_status=='FN')
                                Fine
                              @elseif($project->target_status=='WR')
                                Worning 
                              @elseif($project->target_status=='OD')
                                Over-Due  
                              @endif
                            </td>
                            <td>{{$project->created_by}}</td>
                            <td>{{$project->updated_by}}</td>
                            <th>
                                <a href="/admin/edit-project-{{$project->id}}"><i class="mdi mdi-table-edit" style="color: green;"></i></a>
                                <a href="/admin/delete-project-{{$project->id}}"><i class="mdi mdi-delete-forever" style="color: red;"></i></a>
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
<script src="{{ URL::asset('js/datatables-simple-demo.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection