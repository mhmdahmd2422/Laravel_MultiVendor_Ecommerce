<div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
   <div class="card border">
       <div class="card-body">
           <form action="{{route('admin.stripe-setting.update', 1)}}" method="post">
               @csrf
               @method('PUT')
               <div class="form-group">
                   <label>Stripe Status</label>
                   <select name="status" class="form-control">
                       <option value="">Select</option>
                       <option @isset($stripe_settings->status){{$stripe_settings->status === 1? 'selected': ''}}@endisset value="1">On</option>
                       <option @isset($stripe_settings->status){{$stripe_settings->status === 0? 'selected': ''}}@endisset value="0">Off</option>
                   </select>
               </div>
               <div class="form-group">
                   <label>Account Mode</label>
                   <select name="mode" class="form-control">
                       <option value="">Select</option>
                       <option @isset($stripe_settings->mode){{$stripe_settings->mode === 0? 'selected': ''}}@endisset value="0">SandBox</option>
                       <option @isset($stripe_settings->mode){{$stripe_settings->mode === 1? 'selected': ''}}@endisset value="1">Live</option>
                   </select>
               </div>
               <div class="form-group">
                   <label style="display: block">Country Name</label>
                   <select name="country" class="form-control select2">
                       <option value="">Select</option>
                       @foreach(config('countries.countries') as $country_code => $country_name)
                           <option @isset($stripe_settings->country){{$stripe_settings->country === $country_code? 'selected': ''}}@endisset value="{{$country_code}}">{{$country_name}}</option>
                       @endforeach
                   </select>
               </div>
               <div class="form-group">
                   <label style="display: block">Currency</label>
                   <select name="currency" class="form-control select2">
                       <option value="">Select</option>
                       @foreach(config('settings.currency_list') as $currency_name => $currency_code)
                           <option @isset($stripe_settings->currency){{$stripe_settings->currency === $currency_code? 'selected': ''}}@endisset value="{{$currency_code}}">{{$currency_name}}</option>
                       @endforeach
                   </select>
               </div>
               <div class="form-group">
                   <label>Currency rate ( Per {{$settings->currency_name}} )</label>
                   <input name="currency_rate" type="text" class="form-control" value="{{$stripe_settings->currency_rate?? ''}}">
               </div>
               <div class="form-group">
                   <label>Stripe Client ID</label>
                   <input name="client_id" type="text" class="form-control" value="{{$stripe_settings->client_id?? ''}}">
               </div>
               <div class="form-group">
                   <label>Stripe Secret Key</label>
                   <input name="secret_key" type="text" class="form-control" value="{{$stripe_settings->secret_key?? ''}}">
               </div>
               <button class="btn btn-primary" type="submit">Save</button>
           </form>
       </div>
   </div>
</div>
