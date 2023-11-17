<div class="tab-pane fade" id="list-messages" role="tabpanel"
     aria-labelledby="list-messages-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{route('admin.cod-setting.update', 1)}}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>COD Status</label>
                    <select name="status" class="form-control">
                        <option value="">Select</option>
                        <option @isset($cod_settings->status){{$cod_settings->status === 1? 'selected': ''}}@endisset value="1">On</option>
                        <option @isset($cod_settings->status){{$cod_settings->status === 0? 'selected': ''}}@endisset value="0">Off</option>
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
</div>
