<div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
        <div class="card border">
            <div class="card-body">
                <form action="{{route('admin.advertisement.add-banner')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h4>Left Banner</h4>
                    <input name="banner" type="hidden" value="homepage_banner_four">
                    <div class="form-group">
                        <label>Status</label>
                        <div>
                            <label class='custom-switch'>
                                <input {{@$banner_four->status == 1? 'checked': ''}} name="status" type='checkbox' name='custom-switch-checkbox' class='custom-switch-input'>
                                <span class='custom-switch-indicator'></span>
                            </label>
                        </div>
                    </div>
                    @if($banner_four?->banner_image)
                        <div class="form-group">
                            <img height="100" width="200" src="{{asset(@$banner_four->banner_image)}}">
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="">Banner Image</label>
                        <input name="banner_image" type="file" class="form-control">
                        <input name="banner_old_image" type="hidden" class="form-control" value="{{@$banner_four->banner_image}}">
                    </div>
                    <div class="form-group">
                        <label for="">Banner URL</label>
                        <input name="banner_url" type="text" class="form-control" value="{{@$banner_four->banner_url}}"/>
                    </div>
                    <button class="btn btn-primary mt-4" type="submit">Save</button>
                </form>
            </div>
        </div>
    <div class="row">
        <div class="col-6">
            <div class="card border">
                <div class="card-body">
                    <form action="{{route('admin.advertisement.add-banner')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <h5>Right Top Banner</h5>
                        <br>
                        <input name="banner" type="hidden" value="homepage_banner_five">
                        <div class="form-group">
                            <label>Status</label>
                            <div>
                                <label class='custom-switch'>
                                    <input {{@$banner_five->status == 1? 'checked': ''}} name="status" type='checkbox' name='custom-switch-checkbox' class='custom-switch-input'>
                                    <span class='custom-switch-indicator'></span>
                                </label>
                            </div>
                        </div>
                        @if($banner_five?->banner_image)
                            <div class="form-group">
                                <img height="100" width="200" src="{{asset(@$banner_five->banner_image)}}">
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="">Banner Image</label>
                            <input name="banner_image" type="file" class="form-control">
                            <input name="banner_old_image" type="hidden" class="form-control" value="{{@$banner_five->banner_image}}">
                        </div>
                        <div class="form-group">
                            <label for="">Banner URL</label>
                            <input name="banner_url" type="text" class="form-control" value="{{@$banner_five->banner_url}}"/>
                        </div>
                        <button class="btn btn-primary mt-4" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border">
                <div class="card-body">
                    <form action="{{route('admin.advertisement.add-banner')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <h5>Right Bottom Banner</h5>
                        <br>
                        <input name="banner" type="hidden" value="homepage_banner_six">
                        <div class="form-group">
                            <label>Status</label>
                            <div>
                                <label class='custom-switch'>
                                    <input {{@$banner_six->status == 1? 'checked': ''}} name="status" type='checkbox' name='custom-switch-checkbox' class='custom-switch-input'>
                                    <span class='custom-switch-indicator'></span>
                                </label>
                            </div>
                        </div>
                        @if($banner_six?->banner_image)
                            <div class="form-group">
                                <img height="100" width="200" src="{{asset(@$banner_six->banner_image)}}">
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="">Banner Image</label>
                            <input name="banner_image" type="file" class="form-control">
                            <input name="banner_old_image" type="hidden" class="form-control" value="{{@$banner_six->banner_image}}">
                        </div>
                        <div class="form-group">
                            <label for="">Banner URL</label>
                            <input name="banner_url" type="text" class="form-control" value="{{@$banner_six->banner_url}}"/>
                        </div>
                        <button class="btn btn-primary mt-4" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
