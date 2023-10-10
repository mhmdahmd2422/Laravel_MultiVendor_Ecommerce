<div class="tab-pane fade active show" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
   <div class="card border">
       <div class="card-body">
           <form action="{{route('admin.general-settings.update')}}" method="post">
               @csrf
               @method('PUT')
               <div class="form-group">
                   <label>Site Name</label>
                   <input name="site_name" type="text" class="form-control" value="{{$general_settings->site_name ?? null}}">
               </div>
               <div class="form-group">
                   <label>Layout</label>
                   <select name="layout" class="form-control">
                       <option value="">Select</option>
                       <option {{@$general_settings->layout == 'LTR' ? 'selected' : ''}} value="LTR">LTR</option>
                       <option {{@$general_settings->layout == 'RTL' ? 'selected' : ''}} value="RTL">RTL</option>
                   </select>
               </div>
               <div class="form-group">
                   <label>Contact Email</label>
                   <input name="contact_email" type="email" class="form-control" value="{{$general_settings->contact_email?? null}}">
               </div>
               <div class="form-group">
                   <label>Default Currency</label>
                   <select name="currency_name" class="form-control select2">
                       <option value="">Select</option>
                       @foreach(config('settings.currency_list') as $currency => $currency_code)
                           <option {{@$general_settings->currency_name == $currency_code ? 'selected' : ''}} value="{{$currency_code}}">{{$currency}}</option>
                       @endforeach
                   </select>
               </div>
               <div class="form-group">
                   <label>Currency Icon</label>
                   <input name="currency_icon" type="text" class="form-control" value="{{$general_settings->currency_icon?? null}}">
               </div>
               <div class="form-group">
                   <label>Timezone</label>
                   <select name="timezone" class="form-control select2">
                       <option value="">Select</option>
                       @foreach(config('settings.timezone') as $timezone_code => $timezone)
                           <option {{@$general_settings->timezone == $timezone_code  ? 'selected' : ''}} value="{{$timezone_code}}">{{$timezone}}</option>
                       @endforeach
                   </select>
               </div>
               <button class="btn btn-primary" type="submit">Save</button>
           </form>
       </div>
   </div>
</div>
