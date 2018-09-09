<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin panel menu items
    |--------------------------------------------------------------------------
    |
    | Here you can edit the items to show in the admin menu(on top of the page)
    |
    */
    "list" => [
            [
                    "name"        => "Dashboard",
                    "route"       => "dashboard",
                    "link"        => env('APP_URL').'admin',
                    "permissions" => ["_superadmin"]
            ],
            [
                    "name"        => "Category",
                    "route"       => "categories",
                    "link"        => env('APP_URL').'admin/categories',
                    "permissions" => ["_superadmin"]
            ],
            [
                    "name"        => "Product",
                    "route"       => "products",
                    "link"        => env('APP_URL').'admin/products',
                    "permissions" => ["_superadmin"]
            ],
            [
                    "name"        => "Flavour",
                    "route"       => "flavour",
                    "link"        => env('APP_URL').'admin/flavour',
                    "permissions" => ["_superadmin"]
            ],
            [
                    "name"        => "Branch",
                    "route"       => "branch",
                    "link"        => env('APP_URL').'admin/branch',
                    "permissions" => ["_superadmin"]
            ],
            [
                    "name"        => "Orders",
                    "route"       => "order",
                    "link"        => env('APP_URL').'admin/order',
                    "permissions" => ["_superadmin"]
            ],
            [
                /*
                 * the name of the link: you will 'can_see' filter
                 * just leave this field empty.
                 */
                "name"        => "Users",
                /* the route name associated to the link: used to set
                 * the 'active' flag and to validate permissions of all
                 * the subroutes associated(users.* will be validated for _superadmin and _group-editor permission)
                 */
                "route"       => "users",
                /*
                 * the actual link associated to the menu item
                 */
                "link"        => env('APP_URL').'admin/users/list',
                /*
                 * the list of 'permission name' associated to the menu
                 * item: if the logged user has one or more of the permission
                 * in the list he can see the menu link and access the area
                 * associated with that.
                 * Every route that you create with the 'route' as a prefix
                 * will check for the permissions and throw a 401 error if the
                 * check fails (for example in this case every route named users.*)
                 */
                "permissions" => ["_superadmin"],
                /*
                 * if there is any route that you want to skip for the permission check
                 * put it in this array
                 */
                "skip_permissions" => ["users.selfprofile.edit", "users.profile.edit", "users.profile.addfield", "users.profile.deletefield"]
            ],
            [
                    "name"        => "Groups",
                    "route"       => "groups",
                    "link"        => env('APP_URL').'admin/groups/list',
                    "permissions" => ["_superadmin"]
            ],
            [
                    "name"        => "Permission",
                    "route"       => "permission",
                    "link"        => env('APP_URL').'admin/permissions/list',
                    "permissions" => ["_superadmin"]
            ],
            [
                    "name"        => "Configuration",
                    "route"       => "configuration",
                    "link"        => env('APP_URL').'admin/configuration',
                    "permissions" => ["_superadmin"]
            ],
            [
                    /*
                     * Route to edit the current user profile
                     */
                    "name"        => "",
                    "route"       => "selfprofile",
                    "link"        => env('APP_URL').'admin/users/profile/self',
                    "permissions" => []
            ],
            [
                    /*
                     * Route third screen users
                     */
                    "name"        => "Backman",
                    "route"       => "v1.employee.order",
                    "link"        => env('APP_URL').'employee/v1/order',
                    "permissions" => ["_backman", "_superadmin"]
            ],
            [
                    /*
                     * Route third screen users
                     */
                    "name"        => "Home Screen",
                    "route"       => "/",
                    "link"        => env('APP_URL'),
                    "permissions" => ["_customer", "_superadmin"]
            ],
            [
                    /*
                     * Route third screen users
                     */
                    "name"        => "Manager",
                    "route"       => "v1.employee_admin.order",
                    "link"        => env('APP_URL').'employee_admin/v1/order',
                    "permissions" => ["_manager", "_superadmin"]
            ],

    ]
];