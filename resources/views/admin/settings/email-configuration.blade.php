<div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
   <div class="card border">
       <div class="card-body">
           <form action="{{route('admin.email-settings.update')}}" method="post">
               @csrf
               @method('PUT')
               <div class="form-group">
                   <label>Email</label>
                   <input name="email" type="text" class="form-control" value="{{@$email_settings->email}}">
               </div>
               <div class="form-group">
                   <label>Mail Host</label>
                   <input name="host" type="text" class="form-control" value="{{@$email_settings->host}}">
               </div>
               <div class="row">
                   <div class="col-md-6">
                       <div class="form-group">
                           <label>SMTP Username</label>
                           <input name="username" type="text" class="form-control" value="{{@$email_settings->username}}">
                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="form-group">
                           <label>SMTP Password</label>
                           <input name="password" type="password" class="form-control" value="{{@$email_settings->password}}">
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-6">
                       <div class="form-group">
                           <label>Mail Port</label>
                           <input name="port" type="number" class="form-control" value="{{@$email_settings->port}}">
                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="form-group">
                           <label>Mail Encryption</label>
                           <select name="encryption" class="form-control">
                               <option value="">Select</option>
                               <option {{@$email_settings->encryption === 'tls'? 'selected': ''}} value="tls">TLS</option>
                               <option {{@$email_settings->encryption === 'ssl'? 'selected': ''}} value="ssl">SSL</option>
                           </select>
                       </div>
                   </div>
               </div>
               <button class="btn btn-primary" type="submit">Save</button>
           </form>
       </div>
   </div>
</div>
