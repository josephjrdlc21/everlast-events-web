<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => "portal.users.index", 'description' => "List of Users", 'module' => "users", 'module_name' => "Account Management", 'guard_name' => "portal"],
            ['name' => "portal.users.view", 'description' => "View User Details", 'module' => "users", 'module_name' => "Account Management", 'guard_name' => "portal"],
            ['name' => "portal.users.create", 'description' => "Create New User", 'module' => "users", 'module_name' => "Account Management", 'guard_name' => "portal"],
            ['name' => "portal.users.update", 'description' => "Update User Details", 'module' => "users", 'module_name' => "Account Management", 'guard_name' => "portal"],
            ['name' => "portal.users.search", 'description' => "Search Record", 'module' => "users", 'module_name' => "Account Management", 'guard_name' => "portal"],
            ['name' => "portal.users.edit_password", 'description' => "Reset User Password", 'module' => "users", 'module_name' => "Account Management", 'guard_name' => "portal"],
            ['name' => "portal.users.update_status", 'description' => "Activate or Deactivate User", 'module' => "users", 'module_name' => "Account Management", 'guard_name' => "portal"],
        
            ['name' => "portal.cms.permissions.index", 'description' => "List of Permissions", 'module' => "cms.permissions", 'module_name' => "CMS - Permissions", 'guard_name' => "portal"],
            ['name' => "portal.cms.permissions.search", 'description' => "Search Record", 'module' => "cms.permissions", 'module_name' => "CMS - Permissions", 'guard_name' => "portal"],
        
            ['name' => "portal.cms.roles.index", 'description' => "List of Roles", 'module' => "cms.roles", 'module_name' => "CMS - Roles", 'guard_name' => "portal"],
            ['name' => "portal.cms.roles.create", 'description' => "Create New Role", 'module' => "cms.roles", 'module_name' => "CMS - Roles", 'guard_name' => "portal"],
            ['name' => "portal.cms.roles.update", 'description' => "Update Role Details", 'module' => "cms.roles", 'module_name' => "CMS - Roles", 'guard_name' => "portal"],
            ['name' => "portal.cms.roles.search", 'description' => "Search Record", 'module' => "cms.roles", 'module_name' => "CMS - Roles", 'guard_name' => "portal"],

            ['name' => "portal.cms.category.index", 'description' => "List of Category", 'module' => "cms.category", 'module_name' => "CMS - Category", 'guard_name' => "portal"],
            ['name' => "portal.cms.category.create", 'description' => "Create New Category", 'module' => "cms.category", 'module_name' => "CMS - Category", 'guard_name' => "portal"],
            ['name' => "portal.cms.category.update", 'description' => "Update Category Details", 'module' => "cms.category", 'module_name' => "CMS - Category", 'guard_name' => "portal"],
            ['name' => "portal.cms.category.delete", 'description' => "Delete Category", 'module' => "cms.category", 'module_name' => "CMS - Category", 'guard_name' => "portal"],
            ['name' => "portal.cms.category.search", 'description' => "Search Record", 'module' => "cms.category", 'module_name' => "CMS - Category", 'guard_name' => "portal"],
            ['name' => "portal.cms.category.update_status", 'description' => "Activate or Deactivate Category", 'module' => "cms.category", 'module_name' => "CMS - Category", 'guard_name' => "portal"],
            ['name' => "portal.cms.category.view", 'description' => "View Category Details", 'module' => "cms.category", 'module_name' => "CMS - Category", 'guard_name' => "portal"],

            ['name' => "portal.cms.sponsors.index", 'description' => "List of Sponsor", 'module' => "cms.sponsors", 'module_name' => "CMS - Sponsors", 'guard_name' => "portal"],
            ['name' => "portal.cms.sponsors.create", 'description' => "Create New Sponsor", 'module' => "cms.sponsors", 'module_name' => "CMS - Sponsors", 'guard_name' => "portal"],
            ['name' => "portal.cms.sponsors.update", 'description' => "Update Sponsor Details", 'module' => "cms.sponsors", 'module_name' => "CMS - Sponsors", 'guard_name' => "portal"],
            ['name' => "portal.cms.sponsors.delete", 'description' => "Delete Sponsor", 'module' => "cms.sponsors", 'module_name' => "CMS - Sponsors", 'guard_name' => "portal"],
            ['name' => "portal.cms.sponsors.search", 'description' => "Search Record", 'module' => "cms.sponsors", 'module_name' => "CMS - Sponsors", 'guard_name' => "portal"],
            ['name' => "portal.cms.sponsors.view", 'description' => "View Sponsor Details", 'module' => "cms.sponsors", 'module_name' => "CMS - Sponsors", 'guard_name' => "portal"],

            ['name' => "portal.events.index", 'description' => "List of Events", 'module' => "events", 'module_name' => "Events", 'guard_name' => "portal"],
            ['name' => "portal.events.view", 'description' => "View Event Details", 'module' => "events", 'module_name' => "Events", 'guard_name' => "portal"],
            ['name' => "portal.events.create", 'description' => "Create New Event", 'module' => "events", 'module_name' => "Events", 'guard_name' => "portal"],
            ['name' => "portal.events.update", 'description' => "Update Event Details", 'module' => "events", 'module_name' => "Events", 'guard_name' => "portal"],
            ['name' => "portal.events.search", 'description' => "Search Record", 'module' => "events", 'module_name' => "Events", 'guard_name' => "portal"],
            ['name' => "portal.events.update_is_cancelled", 'description' => "Cancel Event", 'module' => "events", 'module_name' => "Events", 'guard_name' => "portal"],

            ['name' => "portal.users_kyc.index", 'description' => "List of Registrants", 'module' => "registrations", 'module_name' => "Registrations", 'guard_name' => "portal"],
            ['name' => "portal.users_kyc.view", 'description' => "View Registrant Details", 'module' => "registrations", 'module_name' => "Registrations", 'guard_name' => "portal"],
            ['name' => "portal.users_kyc.update_status", 'description' => "Approve or Reject Registrant", 'module' => "registrations", 'module_name' => "Registrations", 'guard_name' => "portal"],
            ['name' => "portal.users_kyc.search", 'description' => "Search Record", 'module' => "registrations", 'module_name' => "Registrations", 'guard_name' => "portal"],

            ['name' => "portal.members.index", 'description' => "List of Members", 'module' => "members", 'module_name' => "Members", 'guard_name' => "portal"],
            ['name' => "portal.members.view", 'description' => "View Member Details", 'module' => "members", 'module_name' => "Members", 'guard_name' => "portal"],
            ['name' => "portal.members.edit_password", 'description' => "Reset Member Password", 'module' => "members", 'module_name' => "Members", 'guard_name' => "portal"],
            ['name' => "portal.members.update_status", 'description' => "Activate or Deactivate Member", 'module' => "members", 'module_name' => "Members", 'guard_name' => "portal"],
            ['name' => "portal.members.search", 'description' => "Search Record", 'module' => "members", 'module_name' => "Members", 'guard_name' => "portal"],

            ['name' => "portal.cms.pages.index", 'description' => "List of Pages", 'module' => "cms.pages", 'module_name' => "CMS - Pages", 'guard_name' => "portal"],
            ['name' => "portal.cms.pages.create", 'description' => "Create New Page", 'module' => "cms.pages", 'module_name' => "CMS - Pages", 'guard_name' => "portal"],
            ['name' => "portal.cms.pages.update", 'description' => "Update Page Details", 'module' => "cms.pages", 'module_name' => "CMS - Pages", 'guard_name' => "portal"],
            ['name' => "portal.cms.pages.view", 'description' => "View Page Details", 'module' => "cms.pages", 'module_name' => "CMS - Pages", 'guard_name' => "portal"],
            ['name' => "portal.cms.pages.search", 'description' => "Search Record", 'module' => "cms.pages", 'module_name' => "CMS - Pages", 'guard_name' => "portal"],
            ['name' => "portal.cms.pages.delete", 'description' => "Delete Page", 'module' => "cms.pages", 'module_name' => "CMS - Pages", 'guard_name' => "portal"],

            ['name' => "portal.cms.faq.index", 'description' => "List of FAQ", 'module' => "cms.faq", 'module_name' => "CMS - FAQ", 'guard_name' => "portal"],
            ['name' => "portal.cms.faq.view", 'description' => "View FAQ Details", 'module' => "cms.faq", 'module_name' => "CMS - FAQ", 'guard_name' => "portal"],
            ['name' => "portal.cms.faq.create", 'description' => "Create New FAQ", 'module' => "cms.faq", 'module_name' => "CMS - FAQ", 'guard_name' => "portal"],
            ['name' => "portal.cms.faq.update", 'description' => "Update FAQ Details", 'module' => "cms.faq", 'module_name' => "CMS - FAQ", 'guard_name' => "portal"],
            ['name' => "portal.cms.faq.update_status", 'description' => "Activate or Deactivate FAQ", 'module' => "cms.faq", 'module_name' => "CMS - FAQ", 'guard_name' => "portal"],
            ['name' => "portal.cms.faq.delete", 'description' => "Delete FAQ", 'module' => "cms.faq", 'module_name' => "CMS - FAQ", 'guard_name' => "portal"],
            ['name' => "portal.cms.faq.search", 'description' => "Search Record", 'module' => "cms.faq", 'module_name' => "CMS - FAQ", 'guard_name' => "portal"],

            ['name' => "portal.bookings.index", 'description' => "List of Bookings", 'module' => "bookings", 'module_name' => "Bookings", 'guard_name' => "portal"],
            ['name' => "portal.bookings.view", 'description' => "View Booking Details", 'module' => "bookings", 'module_name' => "Bookings", 'guard_name' => "portal"],
            ['name' => "portal.bookings.update_status", 'description' => "Approved or Cancel Booking", 'module' => "bookings", 'module_name' => "Bookings", 'guard_name' => "portal"],
            ['name' => "portal.bookings.update_payment", 'description' => "Mark Booking as Paid", 'module' => "bookings", 'module_name' => "Bookings", 'guard_name' => "portal"],
            ['name' => "portal.bookings.search", 'description' => "Search Record", 'module' => "bookings", 'module_name' => "Bookings", 'guard_name' => "portal"],

            ['name' => "portal.cms.settings.index", 'description' => "List of Settings", 'module' => "cms.settings", 'module_name' => "CMS - Settings", 'guard_name' => "portal"],
            ['name' => "portal.cms.settings.search", 'description' => "Search Record", 'module' => "cms.settings", 'module_name' => "CMS - Settings", 'guard_name' => "portal"],
        ];
        
        foreach($permissions as $permission){
            Permission::firstOrCreate(
                ['name' => $permission['name'], 'guard_name' => $permission['guard_name']], $permission
            );
        }
    }
}
