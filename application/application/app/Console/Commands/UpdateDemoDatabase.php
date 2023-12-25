<?php

namespace App\Console\Commands;

use App\Admin;
use App\AdminRole;
use App\AdminRolePermission;
use App\BlackListContact;
use App\Client;
use App\ClientGroups;
use App\ContactList;
use App\CustomSMSGateways;
use App\ImportPhoneNumber;
use App\InvoiceItems;
use App\Invoices;
use App\SMSBundles;
use App\SMSGateways;
use App\SMSHistory;
use App\SMSPlanFeature;
use App\SMSPricePlan;
use App\SMSTemplates;
use App\SupportDepartments;
use App\SupportTickets;
use App\SupportTicketsReplies;
use Illuminate\Console\Command;

class UpdateDemoDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:updatedatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Database in every 1 hour';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        Admin::truncate();

        $admins = [
            [
                'fname' => 'Abul Kashem',
                'lname' => 'Shamim',
                'username' => 'admin',
                'password' => bcrypt('admin.password'),
                'status' => 'Active',
                'email' => 'akasham67@gmail.com',
                'image' => 'profile.jpg',
                'roleid' => '0',
                'emailnotify' => 'No',
                'menu_open' => '1',
            ],
            [
                'fname' => 'Shamim Rahman',
                'lname' => 'Kabbo',
                'username' => 'shamimrahman97',
                'password' => bcrypt('12345678'),
                'status' => 'Active',
                'email' => 'shamimcoc97@gmail.com',
                'image' => 'profile.jpg',
                'roleid' => '1',
                'emailnotify' => 'No',
            ]
        ];


        foreach ($admins as $a) {
            Admin::create($a);
        }


        AdminRole::truncate();
        $admin_role = [
            [
                'role_name' => 'Full Administrator',
                'status' => 'Active'
            ],
            [
                'role_name' => 'Support Engineer',
                'status' => 'Active'
            ]
        ];

        foreach ($admin_role as $role) {
            AdminRole::create($role);
        }

        AdminRolePermission::truncate();

        $role_perams = [
            [
                'role_id' => 1,
                'perm_id' => 1,
            ], [
                'role_id' => 1,
                'perm_id' => 2,
            ], [
                'role_id' => 1,
                'perm_id' => 3,
            ], [
                'role_id' => 1,
                'perm_id' => 4,
            ], [
                'role_id' => 1,
                'perm_id' => 5,
            ], [
                'role_id' => 1,
                'perm_id' => 6,
            ], [
                'role_id' => 1,
                'perm_id' => 7,
            ], [
                'role_id' => 1,
                'perm_id' => 8,
            ], [
                'role_id' => 1,
                'perm_id' => 9,
            ], [
                'role_id' => 1,
                'perm_id' => 10,
            ], [
                'role_id' => 1,
                'perm_id' => 11,
            ], [
                'role_id' => 1,
                'perm_id' => 12,
            ], [
                'role_id' => 1,
                'perm_id' => 13,
            ], [
                'role_id' => 1,
                'perm_id' => 14,
            ], [
                'role_id' => 1,
                'perm_id' => 15,
            ], [
                'role_id' => 1,
                'perm_id' => 16,
            ], [
                'role_id' => 1,
                'perm_id' => 17,
            ], [
                'role_id' => 1,
                'perm_id' => 18,
            ], [
                'role_id' => 1,
                'perm_id' => 19,
            ], [
                'role_id' => 1,
                'perm_id' => 20,
            ], [
                'role_id' => 1,
                'perm_id' => 21,
            ], [
                'role_id' => 1,
                'perm_id' => 22,
            ], [
                'role_id' => 1,
                'perm_id' => 23,
            ], [
                'role_id' => 1,
                'perm_id' => 24,
            ], [
                'role_id' => 1,
                'perm_id' => 25,
            ], [
                'role_id' => 1,
                'perm_id' => 26,
            ], [
                'role_id' => 1,
                'perm_id' => 27,
            ], [
                'role_id' => 1,
                'perm_id' => 28,
            ], [
                'role_id' => 1,
                'perm_id' => 29,
            ], [
                'role_id' => 1,
                'perm_id' => 30,
            ], [
                'role_id' => 1,
                'perm_id' => 31,
            ], [
                'role_id' => 1,
                'perm_id' => 32,
            ], [
                'role_id' => 1,
                'perm_id' => 33,
            ], [
                'role_id' => 1,
                'perm_id' => 34,
            ], [
                'role_id' => 1,
                'perm_id' => 35,
            ], [
                'role_id' => 1,
                'perm_id' => 36,
            ], [
                'role_id' => 1,
                'perm_id' => 37,
            ], [
                'role_id' => 2,
                'perm_id' => 1,
            ], [
                'role_id' => 2,
                'perm_id' => 26,
            ], [
                'role_id' => 2,
                'perm_id' => 27,
            ], [
                'role_id' => 2,
                'perm_id' => 28,
            ], [
                'role_id' => 2,
                'perm_id' => 29,
            ],
        ];

        foreach ($role_perams as $peram) {
            AdminRolePermission::create($peram);
        }


        BlackListContact::truncate();

        $blacklist = [
            [
                'user_id' => 0,
                'numbers' => '8801721889966'
            ],
            [
                'user_id' => 0,
                'numbers' => '8801721668877'
            ]
        ];

        foreach ($blacklist as $bl) {
            BlackListContact::create($bl);
        }


        ClientGroups::truncate();
        ClientGroups::create([
            'group_name' => 'Ultimate SMS'
        ]);


        Client::truncate();

        $api_key = base64_encode('client:client.password');
        Client::create([
            'groupid' => '1',
            'parent' => '0',
            'fname' => 'Shamim',
            'lname' => 'Rahman',
            'company' => 'Codeglen',
            'website' => 'https://codeglen.com',
            'email' => 'codeglen@gmail.com',
            'username' => 'client',
            'password' => bcrypt('client.password'),
            'address1' => '4th Floor, House #11, Block #B, ',
            'address2' => 'Rampura, Banasree Project.',
            'state' => 'Dhaka',
            'city' => 'Dhaka',
            'postcode' => '1219',
            'country' => 'Bangladesh',
            'phone' => '8801700000000',
            'image' => 'profile.jpg',
            'datecreated' => date('Y-m-d'),
            'sms_limit' => '10000',
            'api_access' => 'Yes',
            'api_key' => $api_key,
            'sms_gateway' => '9',
            'status' => 'Active',
            'reseller' => 'Yes',
            'menu_open' => '1',
        ]);


        ContactList::truncate();

        $contact_list = [
            [
                'pid' => 1,
                'phone_number' => '8801721000000',
                'email_address' => 'shamimcoc97@gmail.com',
                'user_name' => 'Shamim',
                'company' => 'Codeglen',
                'first_name' => 'Shamim',
                'last_name' => 'Rahman'
            ], [
                'pid' => 1,
                'phone_number' => '8801913000000',
                'email_address' => 'client@coderpixel.com',
                'user_name' => 'kashem',
                'company' => 'Codeglen',
                'first_name' => 'Abul',
                'last_name' => 'Kashem'
            ], [
                'pid' => 1,
                'phone_number' => '8801670000000',
                'email_address' => null,
                'user_name' => null,
                'company' => null,
                'first_name' => null,
                'last_name' => null
            ],
        ];

        foreach ($contact_list as $list) {
            ContactList::create($list);
        }

        ImportPhoneNumber::truncate();

        ImportPhoneNumber::create([
            'user_id' => 0,
            'group_name' => 'Ultimate SMS'
        ]);

        Invoices::truncate();
        $invoices = [
            [
                'cl_id' => 1,
                'client_name' => 'Shamim Rahman',
                'created_by' => 1,
                'created' => date('Y-m-d'),
                'duedate' => date('Y-m-d'),
                'datepaid' => date('Y-m-d'),
                'subtotal' => '190.00',
                'total' => '190.00',
                'status' => 'Paid',
                'pmethod' => '',
                'recurring' => '0',
                'bill_created' => 'yes',
                'note' => 'One time payment'
            ], [
                'cl_id' => 1,
                'client_name' => 'Shamim Rahman',
                'created_by' => 1,
                'created' => date('Y-m-d'),
                'duedate' => date("Y-m-d", strtotime("+1 month", strtotime(date('Y-m-d')))),
                'datepaid' => date("Y-m-d", strtotime("+1 month", strtotime(date('Y-m-d')))),
                'subtotal' => '15.00',
                'total' => '15.00',
                'status' => 'Unpaid',
                'pmethod' => '',
                'recurring' => '+1 month',
                'bill_created' => 'no',
                'note' => 'Recurring Invoice'
            ]
        ];

        foreach ($invoices as $in) {
            Invoices::create($in);
        }

        InvoiceItems::truncate();

        $invoice_items = [
            [
                'inv_id' => 1,
                'cl_id' => 1,
                'item' => 'Item One',
                'price' => '50.00',
                'qty' => 2,
                'subtotal' => '100.00',
                'tax' => '0.00',
                'discount' => '0.00',
                'total' => '100.00'
            ], [
                'inv_id' => 1,
                'cl_id' => 1,
                'item' => 'Item Two',
                'price' => '30.00',
                'qty' => 3,
                'subtotal' => '90.00',
                'tax' => '0.90',
                'discount' => '0.90',
                'total' => '90.00'
            ], [
                'inv_id' => 2,
                'cl_id' => 1,
                'item' => 'Subscription One',
                'price' => '10.00',
                'qty' => 1,
                'subtotal' => '10.00',
                'tax' => '0.00',
                'discount' => '0.00',
                'total' => '10.00'
            ], [
                'inv_id' => 2,
                'cl_id' => 1,
                'item' => 'Subscription Two',
                'price' => '5.00',
                'qty' => 1,
                'subtotal' => '5.00',
                'tax' => '0.00',
                'discount' => '0.00',
                'total' => '5.00'
            ],
        ];

        foreach ($invoice_items as $item) {
            InvoiceItems::create($item);
        }


        SMSBundles::truncate();
        $sms_bundles = [
            [
                'unit_from' => '0',
                'unit_to' => '5000',
                'price' => '2',
                'trans_fee' => '0'
            ], [
                'unit_from' => '5001',
                'unit_to' => '10000',
                'price' => '1.75',
                'trans_fee' => '0'
            ], [
                'unit_from' => '10001',
                'unit_to' => '20000',
                'price' => '1',
                'trans_fee' => '1'
            ]
        ];

        foreach ($sms_bundles as $bundle) {
            SMSBundles::create($bundle);
        }


        SMSHistory::truncate();

        $sms_history = [
            [
                'userid' => 0,
                'sender' => 'Ultimate SMS',
                'receiver' => '8801721000000',
                'message' => 'Test message',
                'amount' => 1,
                'status' => 'Success',
                'api_key' => null,
                'use_gateway' => 1,
                'send_by' => 'sender'
            ], [
                'userid' => 0,
                'sender' => 'SHAMIM',
                'receiver' => '8801721000001',
                'message' => 'Test message',
                'amount' => 1,
                'status' => 'Invalid Access',
                'api_key' => null,
                'use_gateway' => 1,
                'send_by' => 'sender'
            ], [
                'userid' => 0,
                'sender' => '8801921000000',
                'receiver' => '8801721000001',
                'message' => 'Receive message',
                'amount' => 1,
                'status' => 'Success',
                'api_key' => null,
                'use_gateway' => 1,
                'send_by' => 'receiver'
            ],

            [
                'userid' => 1,
                'sender' => 'Ultimate SMS',
                'receiver' => '8801741045001',
                'message' => 'Message using API',
                'amount' => 1,
                'status' => 'Success',
                'api_key' => $api_key,
                'use_gateway' => 9,
                'send_by' => 'api'
            ], [
                'userid' => 1,
                'sender' => 'Kabbo',
                'receiver' => '8801921504401',
                'message' => 'Test message',
                'amount' => 1,
                'status' => 'Invalid Access',
                'api_key' => null,
                'use_gateway' => 9,
                'send_by' => 'sender'
            ], [
                'userid' => 1,
                'sender' => '8801621022033',
                'receiver' => '8801741045001',
                'message' => 'Receive message',
                'amount' => 1,
                'status' => 'Success',
                'api_key' => null,
                'use_gateway' => 9,
                'send_by' => 'receiver'
            ],
        ];

        foreach ($sms_history as $history) {
            SMSHistory::create($history);
        }


        SMSPricePlan::truncate();
        $price_plan = [
            [
                'plan_name' => 'Basic',
                'price' => '50.00',
                'popular' => 'No',
                'status' => 'Active'
            ], [
                'plan_name' => 'Popular',
                'price' => '100.00',
                'popular' => 'Yes',
                'status' => 'Active'
            ], [
                'plan_name' => 'Premium',
                'price' => '500.00',
                'popular' => 'No',
                'status' => 'Active'
            ]
        ];

        foreach ($price_plan as $plan) {
            SMSPricePlan::create($plan);
        }


        SMSPlanFeature::truncate();

        $plan_feature = [
            [
                'pid' => 1,
                'feature_name' => 'SMS Balance',
                'feature_value' => '500',
                'status' => 'Active'
            ], [
                'pid' => 1,
                'feature_name' => 'Customer Support',
                'feature_value' => '24/7',
                'status' => 'Active'
            ], [
                'pid' => 1,
                'feature_name' => 'Reseller Panel',
                'feature_value' => 'No',
                'status' => 'Active'
            ], [
                'pid' => 1,
                'feature_name' => 'API Access',
                'feature_value' => 'No',
                'status' => 'Active'
            ],

            [
                'pid' => 2,
                'feature_name' => 'SMS Balance',
                'feature_value' => '1000',
                'status' => 'Active'
            ], [
                'pid' => 2,
                'feature_name' => 'Customer Support',
                'feature_value' => '24/7',
                'status' => 'Active'
            ], [
                'pid' => 2,
                'feature_name' => 'Reseller Panel',
                'feature_value' => 'Yes',
                'status' => 'Active'
            ], [
                'pid' => 2,
                'feature_name' => 'API Access',
                'feature_value' => 'No',
                'status' => 'Active'
            ],

            [
                'pid' => 3,
                'feature_name' => 'SMS Balance',
                'feature_value' => '3000',
                'status' => 'Active'
            ], [
                'pid' => 3,
                'feature_name' => 'Customer Support',
                'feature_value' => '24/7',
                'status' => 'Active'
            ], [
                'pid' => 3,
                'feature_name' => 'Reseller Panel',
                'feature_value' => 'Yes',
                'status' => 'Active'
            ], [
                'pid' => 3,
                'feature_name' => 'API Access',
                'feature_value' => 'Yes',
                'status' => 'Active'
            ],
        ];


        foreach ($plan_feature as $feature) {
            SMSPlanFeature::create($feature);
        }


        SMSTemplates::truncate();
        $sms_template = [
            [
                'cl_id' => 0,
                'template_name' => 'Greeting New User',
                'from' => 'Ultimate SMS',
                'message' => 'Hi <%User Name%>, Welcome to <%Company%>',
                'global' => 'no',
                'status' => 'active'
            ], [
                'cl_id' => 0,
                'template_name' => 'Global SMS Template',
                'from' => 'Ultimate SMS',
                'message' => 'Hi <%User Name%> Thank you for being with us!!',
                'global' => 'yes',
                'status' => 'active'
            ],
        ];

        foreach ($sms_template as $template) {
            SMSTemplates::create($template);
        }


        SupportDepartments::truncate();
        $support_department = [
            [
                'name' => 'Support',
                'email' => 'support@example.com',
                'order' => 1,
                'show' => 'Yes'
            ], [
                'name' => 'Billing',
                'email' => 'billing@example.com',
                'order' => 2,
                'show' => 'Yes'
            ],
        ];

        foreach ($support_department as $department) {
            SupportDepartments::create($department);
        }


        SupportTickets::truncate();

        $support_tickets = [
            [
                'did' => 1,
                'cl_id' => 1,
                'admin_id' => 1,
                'name' => 'Shamim Rahman',
                'email' => 'shamimcoc97@gmail.com',
                'date' => date('Y-m-d'),
                'subject' => 'Want New Connection',
                'message' => 'Dramatically fabricate distinctive best practices rather than process-centric synergy. Completely administrate resource maximizing synergy before proactive leadership. Continually negotiate team driven niches whereas sustainable scenarios.',
                'status' => 'Closed',
                'admin' => 'Abul Kashem',
                'replyby' => 'Abul Kashem',
                'closed_by' => 'Abul Kashem'
            ], [
                'did' => 2,
                'cl_id' => 1,
                'admin_id' => 1,
                'name' => 'Shamim Rahman',
                'email' => 'shamimcoc97@gmail.com',
                'date' => date('Y-m-d'),
                'subject' => 'Invoice Overdue',
                'message' => 'Dramatically fabricate distinctive best practices rather than process-centric synergy. Completely administrate resource maximizing synergy before proactive leadership. Continually negotiate team driven niches whereas sustainable scenarios.',
                'status' => 'Pending',
                'admin' => 'Abul Kashem',
                'replyby' => null,
                'closed_by' => null
            ], [
                'did' => 1,
                'cl_id' => 1,
                'admin_id' => 1,
                'name' => 'Shamim Rahman',
                'email' => 'shamimcoc97@gmail.com',
                'date' => date('Y-m-d'),
                'subject' => 'Customization for Operator',
                'message' => 'Dramatically fabricate distinctive best practices rather than process-centric synergy. Completely administrate resource maximizing synergy before proactive leadership. Continually negotiate team driven niches whereas sustainable scenarios.',
                'status' => 'Customer Reply',
                'admin' => 'Abul Kashem',
                'replyby' => 'Shamim Rahman',
                'closed_by' => null
            ], [
                'did' => 1,
                'cl_id' => 1,
                'admin_id' => 0,
                'name' => 'Shamim Rahman',
                'email' => 'shamimcoc97@gmail.com',
                'date' => date('Y-m-d'),
                'subject' => 'Ultimate SMS Customization Invoice',
                'message' => 'Dramatically fabricate distinctive best practices rather than process-centric synergy. Completely administrate resource maximizing synergy before proactive leadership. Continually negotiate team driven niches whereas sustainable scenarios.',
                'status' => 'Answered',
                'admin' => '0',
                'replyby' => 'Abul Kashem',
                'closed_by' => null
            ],
        ];

        foreach ($support_tickets as $ticket) {
            SupportTickets::create($ticket);
        }


        SupportTicketsReplies::truncate();

        $ticket_replies = [
            [
                'tid' => 1,
                'cl_id' => 1,
                'admin_id' => 0,
                'admin' => 'client',
                'name' => 'Shamim Rahman',
                'date' => date('Y-m-d'),
                'message' => 'Yes I am waiting for this',
                'image' => 'profile.jpg'
            ], [
                'tid' => 1,
                'cl_id' => 0,
                'admin_id' => 1,
                'admin' => 'Abul Kashem',
                'name' => '0',
                'date' => date('Y-m-d'),
                'message' => 'We already provide this',
                'image' => 'profile.jpg'
            ], [
                'tid' => 3,
                'cl_id' => 1,
                'admin_id' => 0,
                'admin' => 'client',
                'name' => 'Shamim Rahman',
                'date' => date('Y-m-d'),
                'message' => 'Thank you',
                'image' => 'profile.jpg'
            ], [
                'tid' => 4,
                'cl_id' => 0,
                'admin_id' => 1,
                'admin' => 'Abul Kashem',
                'name' => '0',
                'date' => date('Y-m-d'),
                'message' => 'Check your email',
                'image' => 'profile.jpg'
            ],
        ];

        foreach ($ticket_replies as $reply) {
            SupportTicketsReplies::create($reply);
        }

        SMSGateways::where('custom','Yes')->where('name','!=','Ultimate SMS')->delete();
    }
}
