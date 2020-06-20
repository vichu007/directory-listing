<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha256-AWdeVMUYtwLH09F6ZHxNgvJI37p+te8hJuSMo44NVm0=" crossorigin="anonymous" />
    </head>
    <body>
        <div class="container">
            
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-info mt-3" style="float: right;" data-toggle="modal" data-target="#exampleModal">Upload a file</button>
                </div>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">Files</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                    aria-selected="false">File Logs</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form class="form-inline mt-2 mb-2" method="get" style="float:right;">
                        <div class="form-group">
                          <input type="text" class="form-control" id="search" name="search" value="{{request('search')}}">
                        </div>
                        <button type="submit" class="btn btn-primary ml-1">Search</button>
                    </form>
                    <table class="table mt-3">
                        <thead>
                            <th>Sl.NO</th>
                            <th>File Name</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php
                                if($files->perPage()!=''){
                                    $i = $files->perPage() * ($files->currentPage() - 1);
                                }else{
                                    $i = 0;
                                }
                            ?>
                            @if(count($files))
                                @foreach ($files as $key=>$file)
                                    <?php $i++ ?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td><a href="/storage/images/uploaded_file/{{$file->file_name}}">{{$file->file_name}}</a></td>
                                        <td>
                                            <a href="{{route('delete',$file->id)}}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" align="center">No data found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $files->links() }}
                </div>
                <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table mt-3">
                        <thead>
                            <th>Sl.NO</th>
                            <th>Message</th>
                            <th>Time</th>
                        </thead>
                        <tbody>
                            <?php
                                if($flie_logs->perPage()!=''){
                                    $i = $flie_logs->perPage() * ($flie_logs->currentPage() - 1);
                                }else{
                                    $i = 0;
                                }
                            ?>
                            @if(count($flie_logs))
                                @foreach ($flie_logs as $key=>$file)
                                    <?php $i++ ?>
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$file->message}}</td>
                                        <td>{{date('d/m/Y H:i:s',strtotime($file->created_at))}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" align="center">No data found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $files->links() }}
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('uploadFile')}}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <input type="file" name="input_file" class="dropify" data-default-message="file" data-allowed-file-extensions="txt doc docx pdf png jpeg jpg gif" data-max-file-size="2M" required/>
                            <button type="submit" class="btn btn-success mt-1" style="float: right;">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha256-SUaao5Q7ifr2twwET0iyXVy0OVnuFJhGVi5E/dqEiLU=" crossorigin="anonymous"></script>
        <script>
            $('.dropify').dropify({
                messages: {
                    'default': 'Upload File',
                }
            });
        </script>
    </body>
</html>
