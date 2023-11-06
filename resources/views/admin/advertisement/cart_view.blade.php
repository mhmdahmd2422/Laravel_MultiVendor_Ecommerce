<div class="tab-pane fade" id="list-cart" role="tabpanel" aria-labelledby="list-cart-list">
<div class="row">
    <div class="col-6">
        <div class="card border">
            <div class="card-body">
                <form action="{{route('admin.advertisement.add-banner')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h5>Left Banner</h5>
                    <br>
                    <input name="banner" type="hidden" value="cart_banner_one">
                    <div class="form-group">
                        <label>Status</label>
                        <div>
                            <label class='custom-switch'>
                                <input {{@$cart_banner_one->status == 1? 'checked': ''}} name="status" type='checkbox' name='custom-switch-checkbox' class='custom-switch-input'>
                                <span class='custom-switch-indicator'></span>
                            </label>
                        </div>
                    </div>
                    @if($cart_banner_one?->banner_image)
                        <div class="form-group">
                            <img height="100" width="200" src="{{asset(@$cart_banner_one->banner_image)}}">
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="">Banner Image</label>
                        <input name="banner_image" type="file" class="form-control">
                        <input name="banner_old_image" type="hidden" class="form-control" value="{{@$cart_banner_one->banner_image}}">
                    </div>
                    <div class="form-group">
                        <label for="">Banner URL</label>
                        <input name="banner_url" type="text" class="form-control" value="{{@$cart_banner_one->banner_url}}"/>
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
                    <h5>Right Banner</h5>
                    <br>
                    <input name="banner" type="hidden" value="cart_banner_two">
                    <div class="form-group">
                        <label>Status</label>
                        <div>
                            <label class='custom-switch'>
                                <input {{@$cart_banner_two->status == 1? 'checked': ''}} name="status" type='checkbox' name='custom-switch-checkbox' class='custom-switch-input'>
                                <span class='custom-switch-indicator'></span>
                            </label>
                        </div>
                    </div>
                    @if($cart_banner_two?->banner_image)
                        <div class="form-group">
                            <img height="100" width="200" src="{{asset(@$cart_banner_two->banner_image)}}">
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="">Banner Image</label>
                        <input name="banner_image" type="file" class="form-control">
                        <input name="banner_old_image" type="hidden" class="form-control" value="{{@$cart_banner_two->banner_image}}">
                    </div>
                    <div class="form-group">
                        <label for="">Banner URL</label>
                        <input name="banner_url" type="text" class="form-control" value="{{@$cart_banner_two->banner_url}}"/>
                    </div>
                    <button class="btn btn-primary mt-4" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
