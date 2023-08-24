

    <div class="modal fade" id="makeDeposit" tabindex="-1" aria-labelledby="makeDepositLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header text-center" style="width:100%">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <img src="{{ asset('images/meme.png') }}" alt="" class="mx-auto" width="100">
                    </div>
                    <div class="col-12">
                        <h5 class="modal-title">Deposit Registration Form</h5>
                    </div>
                </div>
            </div>


            <form action="{{ route('admin.registerdeposits') }}" method="POST">
                @csrf
                <div class="modal-body">
                    
                    <label for="client_id" class="form-label">Select Client Name:</label>
                    <select class="form-select" name="client_name" required id="clientSelect">
                        <option value="">Choose</option>
                        <!-- Available members -->
                        @foreach ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->clientName }}</option>
                        @endforeach
                    </select>
                     <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Client ID : </label>
                        <input type="number" class="form-control" id="clientId" name="client_id" placeholder="Client ID" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Deposit Amount </label>
                        <input type="number" class="form-control" id="exampleFormControlInput1" name="deposit_amount" required placeholder="Enter Amount" value="{{old('amount')}}">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Receipt Number</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" required name="receiptNumber" placeholder="Enter receipt number" value="{{old('receipt_number')}}">
                      </div>  
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Date</label>
                        <input type="date" class="form-control" required id="exampleFormControlInput1" name="date" value="{{old('date')}}">
                      </div>    
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 
                    <button type="submit" class="btn btn-primary">Save</button>
              
                </div>
            </form>
          </div>
        </div>
      </div>
      <script>
          document.getElementById('clientSelect').addEventListener('change', function() {
              const selectedOption = this.options[this.selectedIndex];
              document.getElementById('clientId').value = selectedOption.value;
          });
      </script>
