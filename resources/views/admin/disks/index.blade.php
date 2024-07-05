@include('admin.partials.header')
@include('admin.partials.list')

<section class="content">
    <div class="container-fluid">
    <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Диски</h3>

          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 300px;">
          <table class="table table-head-fixed text-nowrap">
            <thead>
              <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 15%;">Название</th>
                <th style="width: 15%">Модель</th>
                <th style="width: 15%">Артикул</th>
                <th>Цена</th>
                <td>Количество на складе</td>
                <th>Изменить</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($disks as $disk)
              <tr>
                <td>{{$disk->id}}</td>
                <td>{{$disk->name}}</td>
                <td>{{$disk->model}}</td>
                <td>{{$disk->weight}}</td>
                <td>{{$disk->height}}</td>
                <td>{{$disk->diametr}}</td>
                <td> <button type="button" class="btn btn-block btn-default">Изменить</button></td>
              </tr>
              @endforeach
             
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>


@include('admin.partials.footer')
