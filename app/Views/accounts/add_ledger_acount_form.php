  <div id="add_ledger_form_data<?= $entype ?>">
          <?= csrf_field(); ?>

          <div class="row">
   
            <div class="col-md-12" >
              <div class="form-group mb-0">
                  <label for="input-2" class="form-label">Ledger Name</label>
                  <input type="text" class="form-control modal_inpu" id="ledger_name" name="ledger_name<?= $entype ?>" required>
              </div>
            </div>

            <div class="col-md-12 mt-3 mb-3">
                <div class="form-group">
                    <label for="input-2" class="form-label">Select group head</label>
                    <select class="form-select" name="group_head" id="group_head" required>
                      <?php foreach (group_head_income_expense_array(company($user['id'])) as $gm): ?>
                          <option value="<?= $gm['id']; ?>"><?= $gm['group_head']; ?></option>
                        
                      <?php endforeach ?>
                    </select>
                </div>
              </div>

            



            <div class="form-group col-md-12 mb-2 ">
               <label for="input-5" class="modal_lab"><?= langg(get_setting(company($user['id']),'language'),'Current Balance'); ?></label>
          
              <input type="number" min="0" step="any" value="0" class="form-control " name="opening_balance" id="opening_balance">
            </div>


            <div class="form-group col-md-4 d-none">
                <label>Type</label>
              <select class="form-control" name="opening_type" id="opening_type">
                  <option value="">To Collect</option>
                  <option value="-">To Pay</option>
              </select>

            </div>



            <div class="form-group col-md-6 mt-2 mb-2">
              <button type="button" class="btn btn-primary add_ledger_data" data-actionurl='<?= base_url('accounts/add_ledger_ajax'); ?>' data-ide="<?= $entype ?>">Save</button>
            </div>
          </div>

          <div id="error_mes">
            
          </div>
  
        </div>

