@extends('app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Comments</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Comments</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <label class="col-sm-2 btn btn-default border ml-auto py-3 mb-3">
                    <i class="fas fa-cloud-upload fa-2xl"></i>
                    Upload</span>
                    <form action="{{ route('data.store') }}" id="dataFrom" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="data" name="json_data" hidden>
                    </form>
                </label>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>List</h4>
                            <div class="card-header-form">
                                <form action="" method="POST">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search" placeholder="Search">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped v_center">
                                    <thead>
                                        <tr>
                                            <th>#SL</th>
                                            <th>Comment Body</th>
                                            <th>Post ID</th>
                                            <th>User</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('custom-scripts')
    <script>
        $('#search').on('keyup', function() {
            search();
        });
        search();

        function search() {
            var keyword = $('#search').val();
            $.post('{{ route('data.details') }}', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    keyword: keyword
                },
                function(data) {
                    table_post_row(data);
                    console.log(data.comments);
                });
        }
        // table row with ajax
        function table_post_row(res) {
            let htmlView = '';
            if (res.comments.data.length <= 0) {
                htmlView += `
       <tr>
          <td colspan="4">No data.</td>
      </tr>`;
            }
            for (let i = 0; i < res.comments.data.length; i++) {
                htmlView += `
        <tr>
           <td>` + (i + 1) + `</td>
              <td>` + res.comments.data[i].body + `</td>
              <td>` + res.comments.data[i].postId + `</td>
               <td><li><strong>ID: </strong>` + res.comments.data[i].user.id +
                    `</li><li><strong>Username: </strong>` +
                    res.comments.data[i].user.username + `</li></td>
        </tr>`;
            }
            $('tbody').html(htmlView);

        }

        $('#data').change(() => {
            $('#dataFrom').submit()
        })
    </script>
@endpush
