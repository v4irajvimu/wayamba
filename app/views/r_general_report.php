<?php if($this->user_permissions->is_view('r_account_report')){ ?>
<link rel="stylesheet" href="<?=base_url()?>css/r_general_report.css" />
<link rel="stylesheet" href="<?=base_url()?>css/treestyle.min.css" />
<link rel="stylesheet" href="<?=base_url()?>css/report.css" />

<script type="text/javascript" src='<?=base_url()?>js/r_general_report.js'></script>

<div class="container">
  <div class="row">
    <div class="col-sm-4">
      <div class="row">
        <h2>Reports</h2>
      </div>
      <div id="jstree" class="row data-box">
        <!-- in this example the tree is populated from inline HTML -->
        <ul>
          <li>Account Reports
            <ul>
              <li id="chart_acc" data-rtype="chart_acc" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
                Chart Of Account
              </li>

              <li id="r_ledger_account" data-rtype="r_ledger_account" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Ledger Account
              </li>

              <li id="acc_det" data-rtype="acc_det" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Account Details
              </li>

              <li id="acc_det_sub" data-rtype="acc_det_sub" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Account Details with Sub Noacc_det_sub
              </li>

              <li id="acc_update" data-rtype="acc_update" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Account Update
              </li>

              <li id="credit_note" data-rtype="credit_note" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Credit Note
              </li>

              <li id="debit_note" data-rtype="debit_note" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Debit Note
              </li>

              <li id="trial_balance" data-rtype="trial_balance" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Trial Balance
              </li>

              <li id="profit_n_lost" data-rtype="profit_n_lost" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Profit And Lost
              </li>

              <li id="balance_sheet" data-rtype="balance_sheet" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Balance Sheet
              </li>

              <li id="jurnal_entry" data-rtype="jurnal_entry" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Jurnal Entry
              </li>

              <li id="opening_balance" data-rtype="opening_balance" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Opening Balance
              </li>

              <li id="trading_report" data-rtype="trading_report" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Trading Report
              </li>

              <li id="sales_report" data-rtype="sales_report" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Sales Report
              </li>



            </ul>
          </li>
          <li>Bank Reports
            <ul>
              <li> Bank Report
                <ul>
                  <li id="bank_entry_list" data-rtype="bank_entry_list" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Bank Entry List
                  </li>

                  <li id="pen_credit_crd_det" data-rtype="pen_credit_crd_det" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Pending Credit Card Details
                  </li>

                  <li id="r_cheque_in_hand" data-rtype="r_cheque_in_hand" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Cheque in Hand
                  </li>

                  <li id="r_issued_pending_cheque" data-rtype="r_issued_pending_cheque" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Issued Cheques 1
                  </li>

                  <li id="r_issued_cheque" data-rtype="r_issued_cheque" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Issued Cheques 2 
                  </li>

                  <li id="chq_b_registry" data-rtype="chq_b_registry" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Cheque Book Registry
                  </li>
                </ul>
              </li>
              <li id="f_post_dated_chq_reg" data-rtype="f_post_dated_chq_reg" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Post Dated Cheques Registry
              </li>

              <li id="f_return_chq_reg" data-rtype="f_return_chq_reg" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Return Cheques Registry
              </li>
            </ul>
          </li>
          <li>Stock Reports
            <ul>
              <li id="r_item_department" data-rtype="r_item_department" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Department List 
              </li>

              <li id="r_item_category" data-rtype="r_item_category" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Item Category
              </li>

              <li id="r_sub_item_category" data-rtype="r_sub_item_category" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Item Sub Category
              </li>

              <li id="itm_lst" data-rtype="itm_lst" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Item List 
              </li>

              <li id="r_stock_in_hand" data-rtype="r_stock_in_hand" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Stock In Hand 
              </li>

              <li id="r_batch_in_hand" data-rtype="r_batch_in_hand" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Stock In Hand Batch Wise
              </li>

              <li id="r_serial_in_hand" data-rtype="r_serial_in_hand" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Stock In Hand Serial Wise
              </li>

              <li id="r_bin_card_stock" data-rtype="r_bin_card_stock" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Bin Card 
              </li>

              <li id="r_stock_detail" data-rtype="r_stock_detail" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Stock Details
              </li>

              <li id="r_stock_details" data-rtype="r_stock_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Stock Movement 
              </li>

              <li id="r_open_stock" data-rtype="r_open_stock" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Opening Stock Report 
              </li>

              <li id="r_sub_item" data-rtype="r_sub_item" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Sub Item Stock Report 
              </li>

              <li id="r_stock_in_hand_wo_zero" data-rtype="r_stock_in_hand_wo_zero" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Stock In Hand Without Zero 
              </li>

              <li id="r_stock_in_hand_all_branch" data-rtype="r_stock_in_hand_all_branch" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Stock In Hand All Branch
              </li>

              <li id="r_stock_in_hand_all_stores" data-rtype="r_stock_in_hand_all_stores" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Stock In Hand All Stores
              </li>
            </ul>
          </li>
          <li>Debitor Reports
            <ul>
              <li id="r_customer_list" data-rtype="r_customer_list" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Customer List 01
              </li>

              <li id="r_customer_list2" data-rtype="r_customer_list2" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Customer List 02
              </li>

              <li id="r_customer_area_list" data-rtype="r_customer_area_list" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Customer Area List
              </li>

              <li id="r_customer_town_list" data-rtype="r_customer_town_list" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Customer Town List
              </li>

              <li id="r_customer_balancesr_customer_analysis" data-rtype="r_customer_balancesr_customer_analysis" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Customer Balance
              </li>

              <li id="r_customer_analysis" data-rtype="r_customer_analysis" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Customer Age Analysis Report
              </li>
            </ul>
          </li>
          <li>Creditor Reports
            <ul>
              <li id="r_category_wise_supplier" data-rtype="r_category_wise_supplier" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Supplier Details 1
              </li>

              <li id="r_purchase_bill" data-rtype="r_purchase_bill" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Supplier Purchase Bill
              </li>

              <li id="r_supplier_balances" data-rtype="r_supplier_balances" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Supplier Balances
              </li>

              <li id="r_supplier_analysis" data-rtype="r_supplier_analysis" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Supplier Age Analysis
              </li>

            </ul>
          </li>
          <li>Transaction Reports
            <ul>
              <li>Purchase
                <ul>
                  <li id="r_purchase_summary" data-rtype="r_purchase_summary" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Purchase Summary
                  </li>

                  <li id="r_purchase_details" data-rtype="r_purchase_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Purchase Details
                  </li>

                  <li id="r_purchase_ret" data-rtype="r_purchase_ret" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Purchase Return Summary
                  </li>

                  <li id="r_purchase_ret_detail" data-rtype="r_purchase_ret_detail" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Purchase Return Details
                  </li>

                  <li id="r_purchase_order_summary" data-rtype="r_purchase_order_summary" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Purchase Order Summary
                  </li>

                  <li id="r_purchase_order_details" data-rtype="r_purchase_order_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Purchase Order Details
                  </li>

                  <li id="r_purchase_order_details" data-rtype="r_purchase_order_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Purchase Order Status
                  </li>

                  <li id="r_po_status" data-rtype="r_po_status" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Purchase Order Quantity Receivedr_purchase_summary
                  </li>

                </ul>
              </li>

              <li>Cash Sales
                <ul>
                  <li id="r_cash_sales_summary" data-rtype="r_cash_sales_summary" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Total Cash Sales Summary 
                  </li>

                  <li id="r_cash_sales_summary_rep" data-rtype="r_cash_sales_summary_rep" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Total Cash Sales Summary Rep Wise
                  </li>

                  <li id="r_cash_sales_details" data-rtype="r_cash_sales_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                    Cash Sales Details
                  </li>

                  <li id="r_cash_sales_details_rep" data-rtype="r_cash_sales_details_rep" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                   Cash Sales Details Rep Wise
                 </li>

                 <li id="r_cash_sales_ret" data-rtype="r_cash_sales_ret" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                  Cash Sales Return Summary
                </li>

                <li id="r_cash_sales_ret_detail" data-rtype="r_cash_sales_ret_detail" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                  Cash Sales Return Details 
                </li>

                <li id="r_reliance_cash_sales_sum" data-rtype="r_reliance_cash_sales_sum" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                  Customer Sales Summery 
                </li>

                <li id="r_cash_sales_gross_profit" data-rtype="r_cash_sales_gross_profit" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                  Cash Sales - Gross Profit
                </li>
              </ul>
            </li>

            <li>Credit Sales
              <ul>
                <li id="r_credit_sales_summary" data-rtype="r_credit_sales_summary" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                  Credit Sales Summary  
                </li>

                <li id="r_credit_sales_summary_rep" data-rtype="r_credit_sales_summary_rep" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                 Total Credit Sales Summary Rep Wise
               </li>

               <li id="r_credit_sales_details_rep" data-rtype="r_credit_sales_details_rep" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
                Total Credit Sales Details Rep Wise
              </li>

              <li id="r_credit_sales_details" data-rtype="r_credit_sales_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
               Credit Sales Details 
             </li>

             <li id="r_credit_sales_ret" data-rtype="r_credit_sales_ret" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
              Credit Sales Return Summary 
            </li>

            <li id="r_credit_sales_ret_detail" data-rtype="r_credit_sales_ret_detail" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
              Credit Sales Return Details 
            </li>

            <li id="r_credit_sales_gross_profit" data-rtype="r_credit_sales_gross_profit" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
              Credit Sales Gross Profit 
            </li>

            <li id="r_credit_sales_outstanding" data-rtype="r_credit_sales_outstanding" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
              Credit Sales Outstanding 
            </li>
          </ul>
        </li>

        <li>Total Sales
          <ul>
            <li id="r_total_sale" data-rtype="r_total_sale" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
              Total Sales Report   
            </li>

            <li id="r_total_sales_report_02" data-rtype="r_total_sales_report_02" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
             Total Sales Report 02 
           </li>

           <li id="r_total_sale_emp" data-rtype="r_total_sale_emp" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
            Employee Total Sales Report 
          </li>

          <li id="r_total_sale_gross_profit" data-rtype="r_total_sale_gross_profit" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
           Total Sales Gross Profit Report 
         </li>

         <li id="r_total_sale_summary" data-rtype="r_total_sale_summary" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
          Total Sales Summary Report 
        </li>

        <li id="r_total_sale_catwise" data-rtype="r_total_sale_catwise" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
          Total Sales Report Category Wise 
        </li>
      </ul>
    </li>

    <li>Internel Transfer 
      <ul>
        <li id="r_internal_transfer_summary" data-rtype="r_internal_transfer_summary" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
          Internal Transfer Summary   
        </li>

        <li id="r_int_tr_det" data-rtype="r_int_tr_det" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
         Internal Transfer Details  
       </li>

       <li id="r_int_tr_rec_sum" data-rtype="r_int_tr_rec_sum" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
        Internal Transfer Receive Summary 
      </li>

      <li id="r_int_tr_rec_det" data-rtype="r_int_tr_rec_det" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
       Internal Transfer Receive Details 
     </li>

     <li id="r_int_tr_order_sum" data-rtype="r_int_tr_order_sum" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
      Internal Transfer Order Summary
    </li>

    <li id="r_int_tr_order_det" data-rtype="r_int_tr_order_det" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
      Internal Transfer Order Details 
    </li>
  </ul>
</li>

<li>Voucher Reports 
  <ul>
    <li id="r_voucher_lists" data-rtype="r_voucher_lists" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
      Voucher List 01 (supplier Payment)    
    </li>

    <li id="r_cancelled_voucher_lists" data-rtype="r_cancelled_voucher_lists" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
     Cancelled Voucher List 01(supplier Payment)   
   </li>

   <li id="r_petty_cash" data-rtype="r_petty_cash" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
    Petty Cash Summery 
  </li>

  <li id="r_cancelled_petty_cash" data-rtype="r_cancelled_petty_cash" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
   Cancelled Petty Cash Summery 
 </li>

 <li id="r_petty_cash_details" data-rtype="r_petty_cash_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
  Petty Cash Details 
</li>

<li id="r_general_voucher_summery" data-rtype="r_general_voucher_summery" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
  General Voucher List (Summery) 
</li>

<li id="r_general_voucher_groued" data-rtype="r_general_voucher_groued" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
 General Voucher List (Grouped) 
</li>

<li id="r_cancelled_general_voucher_summery" data-rtype="r_cancelled_general_voucher_summery" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
  Cancelled General Voucher List (Summery) 
</li>

<li id="r_general_voucher_details" data-rtype="r_general_voucher_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
 General Voucher List (Details) 
</li>

<li id="r_payable_invoice_summery" data-rtype="r_payable_invoice_summery" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
  Payable Invoice (Summery) 
</li>

<li id="r_payable_invoice_details" data-rtype="r_payable_invoice_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
  Payable Invoice (Details)
</li>
</ul>
</li>

<li>Receipt List 
  <ul>
    <li id="r_advanced_payment_lists" data-rtype="r_advanced_payment_lists" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
      Advanced Payment List     
    </li>

    <li id="r_cancelled_advanced_payment_lists" data-rtype="r_cancelled_advanced_payment_lists" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
     Cancelled Advanced Payment List   
   </li>

   <li id="r_receipt_lists" data-rtype="r_receipt_lists" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
    Receipt List (Customer Payment) 
  </li>

  <li id="r_cancelled_receipt_lists" data-rtype="r_cancelled_receipt_lists" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
   Cancelled Receipt List (Customer Payment) 
 </li>

 <li id="r_receipt_lists_2" data-rtype="r_receipt_lists_2" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
  Receipt List 02 (Customer Payment) 
</li>

<li id="r_cancelled_receipt_lists_2" data-rtype="r_cancelled_receipt_lists_2" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
  Cancelled Receipt List 02 (Customer Payment) 
</li>

<li id="r_general_recipt_summery" data-rtype="r_general_recipt_summery" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
 General Reciept List (Summery)  
</li>

<li id="r_cancelled_general_recipt_summery" data-rtype="r_cancelled_general_recipt_summery" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
  Cancelled General Voucher List (Summery) 
</li>

<li id="r_general_recipt_Details" data-rtype="r_general_recipt_Details" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
 General Reciept List (Details) 
</li>

<li id="r_recievalble_invoice_summery" data-rtype="r_recievalble_invoice_summery" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
  Recievalble Invoice (Summery) 
</li>

<li id="r_recievable_invoice_details" data-rtype="r_recievable_invoice_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
  Recievalble Invoice (Details) 
</li>
</ul>
</li>

<li id="r_group_sale_balance" data-rtype="r_group_sale_balance" data-jstree='{"icon":"glyphicon glyphicon-file"}'> 
  Group Sales Balance

</li>

<li>
  Card and Cash Sales 
  <ul>
    <li id="r_card_and_cash_sales_gross_profit" data-rtype="r_card_and_cash_sales_gross_profit" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
      Card and Cash Sales Gross Profit 
    </li>
  </ul>

</li>

<li>Sles Order Sales
  <ul>
    <li id="r_sales_order_sales_gross_profit" data-rtype="r_sales_order_sales_gross_profit" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
      Sales Order Sales - Gross Profit 
    </li>
  </ul>

</li>
</ul>
</li>
<li>Hire Purchase Reports 
  <ul>
    <li id="r_hp_sales_summary" data-rtype="r_hp_sales_summary" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
      Sales Summary All 
    </li>

    <li id="r_hp_sales_details" data-rtype="r_hp_sales_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
      Sales Details 
    </li>

    <li id="r_hp_closed_accounts" data-rtype="r_hp_closed_accounts" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
      Closed Accounts
    </li>

    <li id="r_hp_other_charges_sum" data-rtype="r_hp_other_charges_sum" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
     Other charges summary 
   </li>

   <li id="r_hp_return_summary" data-rtype="r_hp_return_summary" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
    Return Summary 
  </li>

  <li id="r_hp_other_charges_details" data-rtype="r_hp_other_charges_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
    Other Charges Details
  </li>

  <li id="r_hp_total_outstanding" data-rtype="r_hp_total_outstanding" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
    Total Outstandings 
  </li>

  <li id="r_hp_sales_summary_sm_wise" data-rtype="r_hp_sales_summary_sm_wise" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
    Sales Summary Salesman Wise
  </li>

  <li id="r_arrears_list" data-rtype="r_arrears_list" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
    Arrears List 
  </li>

  <li id="r_default_interrest_sum" data-rtype="r_default_interrest_sum" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
   Default Interrest Summary
 </li>

 <li id="r_arrears_letter_1" data-rtype="r_arrears_letter_1" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
  Arrears Letter 1
</li>

<li id="r_arrears_letter_2" data-rtype="r_arrears_letter_2" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
  Arrears Letter 2 
</li>

<li id="r_hp_due_summary" data-rtype="r_hp_due_summary" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
  Due Summary 
</li>

<li id="r_hp_total_outstanding_rep" data-rtype="r_hp_total_outstanding_rep" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
  Total Outstanding Rep Wise
</li>

<li id="r_receipt_list_c" data-rtype="r_receipt_list_c" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
  Receipt List (Collection) 
</li>

<li id="r_downpayment_rec_list" data-rtype="r_downpayment_rec_list" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
  Downpayment Receipt List
</li>

<li id="r_given_installment_arr" data-rtype="r_given_installment_arr" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
  Given Installment Arrears Report 
</li>

<li id="r_dd_installment_details" data-rtype="r_dd_installment_details" data-jstree='{"icon":"glyphicon glyphicon-file"}'>
  Daily Due Installment Details
</li>
</ul>
</li>
<li>Summery Reports
  <ul>
    <li id="m_dialy_summery" data-rtype="m_dialy_summery" data-jstree='{"icon":"glyphicon glyphicon-file"}'>Daily Summery</li>
  </ul>
</li>
</ul>
</div>
</div>

<div class="col-sm-8">
  <div class="data-box">
    <!-- Date from - to filteration -->
    <div class="row">
      <div class="col-sm-offset-1 col-sm-5">
        <p class="inline"><span class="glyphicon glyphicon-calendar"> From:</span></p>
        <input id="from_date" name="from_date"   class="inline input_date_down_future " type="text">
      </div>
      <div class="col-sm-offset-1 col-sm-5">
        <p class="inline"><span class="glyphicon glyphicon-calendar"> To:</span></p>
        <input id="to_date" name="to_date"  class="input_date_down_future inline" type="text">
      </div>  
    </div>

    <!-- Multiple options filteration -->
    <div class="row">
      <div id="multifilters" class="history_tabs ">
        <ul  class="nav nav-pills">
          <li class="active"><a  href="#tb_clusters" data-toggle="tab">Clusters</a></li>
          <li><a href="#tb_branches" data-toggle="tab">Branches</a></li>
          <li><a href="#tb_stores" data-toggle="tab">Stores</a></li>

        </ul>

        <div class="tab-content clearfix">
          <div class="tab-pane active" id="tb_clusters">
           <div class="div_cluster">
            <?=$cluster?>
          </div>
        </div>
        <div class="tab-pane" id="tb_branches">
          <div class="div_branch"></div>
        </div>
        <div class="tab-pane" id="tb_stores">
          <div class="div_stores"></div>
        </div>
      </div>

    </div>
  </div>
  <!-- Filteratins General -->
  <div class="row">
      <div class="col-sm-offset-1 col-sm-5">
        <p class="inline"><span class="glyphicon glyphicon-calendar"> From:</span></p>
        <input id="from_date" name="from_date"   class="inline input_date_down_future " type="text">
      </div>
      <div class="col-sm-offset-1 col-sm-5">
        <p class="inline"><span class="glyphicon glyphicon-calendar"> To:</span></p>
        <input id="to_date" name="to_date"  class="input_date_down_future inline" type="text">
      </div>  
    </div>



</div>
</div>
</div>


<?php } ?>