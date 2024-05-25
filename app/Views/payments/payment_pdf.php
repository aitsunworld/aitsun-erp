<style type="text/css">
  .invoice_page {
    background: white;
    color: black;
    padding:0 20px;
    border-radius: 5px;
    overflow: auto;
}
.mb-0, .my-0 {
    margin-bottom: 0!important;
}

.mt-auto, .my-auto {
    margin-top: auto!important;
}

.mb-auto, .my-auto {
    margin-bottom: auto!important;
}

.w-100{
    width: 100%!important;
  }

  .d-block{
    display: block!important;
  }

  .pl-2, .px-2 {
    padding-left: .5rem!important;
}
.pr-2, .px-2 {
    padding-right: .5rem!important;
}
.mt-2, .my-2 {
    margin-top: .5rem!important;
}

.text-right td{
  text-align: right!important;
}

.pl-5, .px-5 {
    padding-left: 3rem!important;
}

table{
  border-spacing: -1px;
}

.h6, h6 {
    font-size: .91rem;
}

p {
    margin-top: 0;
    margin-bottom: 1rem;
}

.text-dark {
    color: #343a40!important;
}

.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    color: #495057;
    font-weight: 600;
}
.h4, h4 {
    font-size: 1.365rem;
}

.text-right {
    text-align: right!important;
}

.text-center {
    text-align: center!important;
}

.mt-2, .my-2 {
    margin-top: .5rem!important;
}

.invoice_hr {
    border-top: 1px solid rgb(0 0 0 / 32%);
}

.pt-2, .py-2 {
    padding-top: .5rem!important;
}

.pt-4, .py-4 {
    padding-top: 1.5rem!important;
}


.d-flex {
    display: -webkit-box!important;
    display: -ms-flexbox!important;
    display: flex!important;
}

.pb-1, .py-1 {
    padding-bottom: .25rem!important;
}
.pt-1, .py-1 {
    padding-top: .25rem!important;
}

.m-0 {
    margin: 0!important;
}
.mb-auto, .my-auto {
    margin-bottom: auto!important;
}
.mt-auto, .my-auto {
    margin-top: auto!important;
}

body {
    margin: 0;
    font-family: Nunito,sans-serif;
    font-size: .91rem;
    font-weight: 500;
    line-height: 1.5;
}

.h5, h5 {
    font-size: 1.1375rem;
}

.tax_list {
    list-style: none;
    margin-bottom: 0;
    font-size: 12px;
    padding: 0;
}
.company_logo {
    width: auto;
    height: 60px;
    margin-top: auto;
    margin-bottom: auto;
    object-fit: cover;
    object-position: center;
}
.pb-2, .py-2 {
    padding-bottom: .5rem!important;
}
.pt-2, .py-2 {
    padding-top: .5rem!important;
}
.product_table td {
    padding-left: .5rem;
    padding-right: .5rem;
}
.mt-3, .my-3 {
    margin-top: 1rem!important;
}
.d-flex {
    display: -webkit-box!important;
    display: -ms-flexbox!important;
    display: flex!important;
}
.text-right {
    text-align: right!important;
}
.text-center {
    text-align: center!important;
}
</style>

<div id="pdfthis" class="invoice_page">
  <?php if ( get_setting(company($user['id']),'receipt_template')==1): ?>

      <?php  receipt_show($pmt['id'],company($user['id']),$user['id'],$pmt['bill_type'],$pmt['customer'],$pmt['alternate_name'],$pmt['type'],aitsun_round($pmt['amount'],round_after()),$pmt['payment_note'],$pmt['account_name'],$pmt['datetime']); ?>

  <?php elseif ( get_setting(company($user['id']),'receipt_template')==2): ?>

      <?php  receipt_show1($pmt['id'],company($user['id']),$user['id'],$pmt['bill_type'],$pmt['customer'],$pmt['alternate_name'],$pmt['type'],aitsun_round($pmt['amount'],round_after()),$pmt['payment_note'],$pmt['account_name'],$pmt['datetime']); ?>

  <?php endif; ?>    
</div>