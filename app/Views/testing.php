 <br>
 <br>
 <br>
 <br>
 <form action="<?= base_url('testing');?>" class="submit_loader w-50 m-auto text-center spsec-validation" id="spsec-validation" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                <?= csrf_field(); ?>
                                <div class="form-group position-relative mb-2">
                                    <input type="file" name="fileURL" id="file-url" class="filestyle form-control custom-file-input" data-allowed-file-extensions="[CSV, csv, xlsx]" accept=".CSV, .csv, .xlsx" data-buttontext="Choose File" required>
                                </div>
                                <div class="form-group mt-4">
                                    <button type="submit" name="import_csv" id="import_csv" class="btn btn-dark erp_round btn-sm">Resubmit the file</button>
                                </div> 

                                
                            </form>