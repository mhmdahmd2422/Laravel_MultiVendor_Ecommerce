<div class="tab-pane fade active show" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
   <div class="card border">
       <div class="card-body">
           <form action="{{route('admin.advertisement.add-banner')}}" method="post" enctype="multipart/form-data">
               @csrf
               @method('PUT')
               <input name="banner" type="hidden" value="homepage_banner_one">
               <div class="form-group">
                   <label>Status</label>
                   <div>
                       <label class='custom-switch'>
                           <input {{@$banner_one->status == 1? 'checked': ''}} name="status" type='checkbox' name='custom-switch-checkbox' class='custom-switch-input'>
                           <span class='custom-switch-indicator'></span>
                       </label>
                   </div>
               </div>
               @if($banner_one?->banner_image)
                   <div class="form-group">
                       <img height="100" width="200" src="{{asset(@$banner_one->banner_image)}}">
                   </div>
               @endif
               <div class="form-group">
                   <label for="">Banner Image</label>
                   <input name="banner_image" type="file" class="form-control">
                   <input name="banner_old_image" type="hidden" class="form-control" value="{{@$banner_one->banner_image}}">
               </div>
               <div class="form-group">
                   <label for="">Banner URL</label>
                   <input name="banner_url" type="text" class="form-control" value="{{@$banner_one->banner_url}}"/>
               </div>
               <button class="btn btn-primary mt-4" type="submit">Save</button>
           </form>
       </div>
   </div>
</div>
