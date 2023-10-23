<div class="tab-pane fade active show" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
   <div class="card border">
       <div class="card-body">
           <form action="{{route('admin.paypal-setting.update', 1)}}" method="post">
               @csrf
               @method('PUT')
               <div class="form-group">
                   <label>Paypal Status</label>
                   <select name="status" class="form-control">
                       <option value="">Select</option>
                       <option @isset($paypal_settings->status){{$paypal_settings->status === 1? 'selected': ''}}@endisset value="1">On</option>
                       <option @isset($paypal_settings->status){{$paypal_settings->status === 0? 'selected': ''}}@endisset value="0">Off</option>
                   </select>
               </div>
               <div class="form-group">
                   <label>Account Mode</label>
                   <select name="mode" class="form-control">
                       <option value="">Select</option>
                       <option @isset($paypal_settings->mode){{$paypal_settings->mode === 0? 'selected': ''}}@endisset value="0">SandBox</option>
                       <option @isset($paypal_settings->mode){{$paypal_settings->mode === 1? 'selected': ''}}@endisset value="1">Live</option>
                   </select>
               </div>
               <div class="form-group">
                   <label>Country Name</label>
                   <select name="country" class="form-control select2">
                       <option value="">Select</option>
                       @foreach(config('countries.countries') as $country_code => $country_name)
                           <option @isset($paypal_settings->country){{$paypal_settings->country === $country_code? 'selected': ''}}@endisset value="{{$country_code}}">{{$country_name}}</option>
                       @endforeach
                   </select>
               </div>
               <div class="form-group">
                   <label>Currency</label>
                   <select name="currency" class="form-control select2">
                       <option value="">Select</option>
                       @foreach(config('settings.currency_list') as $currency_name => $currency_code)
                           <option @isset($paypal_settings->currency){{$paypal_settings->currency === $currency_code? 'selected': ''}}@endisset value="{{$currency_code}}">{{$currency_name}}</option>
                       @endforeach
                   </select>
               </div>
               <div class="form-group">
                   <label>Currency rate ( Per USD )</label>
                   <input name="currency_rate" type="text" class="form-control" value="{{$paypal_settings->currency_rate?? ''}}">
               </div>
               <div class="form-group">
                   <label>Paypal Client ID</label>
                   <input name="client_id" type="text" class="form-control" value="{{$paypal_settings->client_id?? ''}}">
               </div>
               <div class="form-group">
                   <label>Paypal Secret Key</label>
                   <input name="secret_key" type="text" class="form-control" value="{{$paypal_settings->secret_key?? ''}}">
               </div>
               <button class="btn btn-primary" type="submit">Save</button>
           </form>
       </div>
   </div>
</div>
