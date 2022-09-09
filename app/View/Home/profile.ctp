 <div class="row">
            <div class="col-12 mt-5">
                <div class="card">

                    <div class="card-body">
                        <div class="card-title mb-4">
                            <div class="d-flex justify-content-start">
                                <div class="image-container" style="width: 84%;">
                                    
                                    <img id="imgProfile" style="width: 150px; height: 150px" />
      
                                </div>
                                <div>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#profileModal"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="tab-content ml-1" id="myTabContent">
                                    <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
                                        

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Name</label>
                                            </div>
                                            <div class="col-md-8 col-6" id="p_name">
                                                
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Email</label>
                                            </div>
                                            <div class="col-md-8 col-6" id="p_email">
                                                
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Birth Date</label>
                                            </div>
                                            <div class="col-md-8 col-6" id="p_bdate">
                                                
                                            </div>
                                        </div>
                                        <hr />
                                        
                                        
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Gender</label>
                                            </div>
                                            <div class="col-md-8 col-6" id="p_gender">
                                                
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Hobby</label>
                                            </div>
                                            <div class="col-md-8 col-6" id="p_hobby">
                                                
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="connectedServices" role="tabpanel" aria-labelledby="ConnectedServices-tab">
                                        Facebook, Google, Twitter Account that are connected to this account
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>

        <!-- The Modal -->
<div class="modal" id="profileModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Profile</h4>
       <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form id="profileForm" enctype="multipart/form-data">
           <label for="name">Image:</label>
          <div class="mb-3 mt-3">
            <input type="file" class="form-control-file border" name="image" id="image" >
          </div>
          <div class="mb-3 mt-3">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="ep_name" placeholder="Enter name" name="name">
          </div>
          <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="ep_email" placeholder="Enter email" name="email">
          </div>
          <div class="mb-3">
            <label for="birthdate">Birthdate:</label>
            <input type="date" class="form-control" id="ep_bdate" name="birthdate">
          </div>
           <div class="mb-3">
            <label for="birthdate">Gender:</label>
            <div class="form-check-inline">
              <label class="form-check-label" for="radio1">
                <input type="radio" class="form-check-input" id="radio1" name="gender" value="Male" checked>Male
              </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                <input type="radio" class="form-check-input" id="radio2" name="gender" value="Female">Female
                </label>
            </div>
            <div class="form-group">
                <label for="comment">Hobby:</label>
                <textarea class="form-control" rows="5" id="ep_hobby" name="hobby"></textarea>
            </div>
          <button class="btn btn-primary" id="btnSave" name="btnSave">Save</button>
        </form>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>