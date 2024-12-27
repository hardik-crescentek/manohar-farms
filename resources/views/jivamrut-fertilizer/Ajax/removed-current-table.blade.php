<table class="table table-bordered datatable" id="current-barrels-table" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Ingredients</th>
            <th>Barrel(QTY)</th>
            <th>Date</th>
            <th>Removed Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($jivamrutBarrelsCurrent) && !$jivamrutBarrelsCurrent->isEmpty())
        @foreach($jivamrutBarrelsCurrent as $key => $item)
                <tr class="tr-{{$item->id}}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->ingredients }}</td>
                    <td>{{ $item->barrel_qty }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->removed_date)) }}</td>
                    <td>
                        <a href="javascript:;" title="Edit" data-target="#editBarrel{{$item->id}}" data-toggle="modal"> <i class="fa fa-pen text-primary mr-2"></i> </a>

                        <div class="modal editBarrel" id="editBarrel{{$item->id}}">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Barrel</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form class="parsley-validate" method="post" action="{{ route('jivamrut-fertilizer.update-barrel-entries', $item->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-body">
                                            <div class="row row-sm">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="date">Date</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="fe fe-calendar lh--9 op-6"></i>
                                                                </div>
                                                            </div>
                                                            <input class="form-control datepicker" placeholder="DD/MM/YYYY" type="text" name="date" id="current-edit-date" value="{{ $item->date != null ? date('d-m-Y', strtotime($item->date)) : '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="">Barrel  (QTY)</label>
                                                        <input class="form-control" name="barrel_qty" type="number" value="{{ $item->barrel_qty }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="">Ingredients</label>
                                                        <input class="form-control" name="ingredients" type="text" value="{{ $item->ingredients }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn ripple btn-primary" type="submit">Save changes</button>
                                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>