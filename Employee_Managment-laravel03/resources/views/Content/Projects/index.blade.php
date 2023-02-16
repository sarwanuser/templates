@extends('admin.template.base')

@section('title', 'All Projects ')

@section('styles')
    <style>
      .mdi-plus{
          cursor: pointer;
          color: green;
          padding: 1px 3px !important;
      }
    </style>
@endsection

@section('content')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">All Projects </h3>
              <a href="{{url('admin/addprojectsdetails')}}"><i class="mdi mdi-plus btn btn-success" title="Click for add new projects"></i></a>
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
                            <th>Project Title</th>
                            <th>Main Image</th>
                            <!-- <th>Description</th> -->
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @php $x=1; @endphp
                        @foreach($data as $datas)
                          <tr>
                            <td>{{$x++}}</td>
                            <td>{{$datas->pr_main_title}}</td>
                            <td>
                              @if(!empty($datas->pr_main_image))
                                <img class="img-lg rounded-circle" src="{{ URL::to('/') }}/images/projects/{{$datas->pr_main_image}}" alt="profile photo">
                              @endif
                            </td>
                            {{--<td>{{$datas->description}}</td>--}}
                            <td>{{$datas->created_by}}</td>
                            <td>{{$datas->updated_by}}</td>
                            <th>
                                <a href="/admin/edit-projects-details-{{$datas->id}}"><i class="mdi mdi-table-edit" style="color: green;"></i></a>
                                <a href="/admin/delete-projects-details-{{$datas->id}}"><i class="mdi mdi-delete-forever" style="color: red;"></i></a>
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