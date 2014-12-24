<?php

namespace Phire\Form;

use Phire\Table;
use Pop\Form\Form;
use Pop\Validator;

class UserRole extends Form
{

    /**
     * Constructor
     *
     * Instantiate the form object
     *
     * @param  array  $resources
     * @param  array  $permissions
     * @param  int    $id
     * @param  array  $fields
     * @param  string $action
     * @param  string $method
     * @return UserRole
     */
    public function __construct(array $resources, array $permissions = null, $id = 0, array $fields = null, $action = null, $method = 'post')
    {
        $parentRoles = ['----' => '----'];

        $roles = Table\UserRoles::findAll();
        if ($roles->count() > 0) {
            foreach ($roles->rows() as $role) {
                if ($role['id'] != $id) {
                    $parentRoles[$role['id']] = $role['name'];
                }
            }
        }

        $fields = [];

        $fields[] = [
            'submit' => [
                'type'       => 'submit',
                'value'      => 'Save',
                'attributes' => [
                    'class'  => 'save-btn'
                ]
            ],
            'parent_id' => [
                'type'       => 'select',
                'label'      => 'Parent',
                'value'      => $parentRoles
            ],
            'verification' => [
                'type'      => 'radio',
                'label'     => 'Verification',
                'value'     => [
                    '1' => 'Yes',
                    '0' => 'No'
                ],
                'marked' => 0
            ],
            'approval' => [
                'type'      => 'radio',
                'label'     => 'Approval',
                'value'     => [
                    '1' => 'Yes',
                    '0' => 'No'
                ],
                'marked' => 0
            ],
            'email_as_username' => [
                'type'      => 'radio',
                'label'     => 'Email as Username',
                'value'     => [
                    '1' => 'Yes',
                    '0' => 'No'
                ],
                'marked' => 0
            ],
            'id' => [
                'type'  => 'hidden',
                'value' => '0'
            ]
        ];

        $fields[] = [
            'name' => [
                'type'       => 'text',
                'label'      => 'Name',
                'required'   => 'true',
                'attributes' => [
                    'onkeyup' => 'phire.changeTitle(this.value);'
                ]
            ],
        ];

        $resourceValues = ['----' => '----'];

        foreach ($resources as $resource => $perms) {
            $resourceValues[$resource] = $resource ;
        }

        $fields[] = [
            'resource_new_1' => [
                'type'       => 'select',
                'label'      => '<a href="#" onclick="phire.addResource(); return false">[+]</a> Resources &amp; Permissions',
                'value'      => $resourceValues,
                'attributes' => [
                    'style'    => 'display: block; margin-right: 5px; margin-bottom: 5px; width: 200px;',
                    'onchange' => 'phire.changePermissions(this, \'' . BASE_PATH . APP_URI . '\');'
                ]
            ],
            'permission_new_1' => [
                'type'       => 'select',
                'value'      => ['----' => '----'],
                'attributes' => [
                    'style' => 'display: block; margin-right: 5px; margin-bottom: 5px; width: 100px;'
                ]
            ],
            'allow_new_1' => [
                'type'     => 'select',
                'value'    => [
                    '----' => '----',
                    '0'    => 'deny',
                    '1'    => 'allow'
                ],
                'attributes' => [
                    'style' => 'display: block; margin-bottom: 5px; width: 100px;'
                ]
            ]
        ];

        if (null !== $permissions) {
            $i = 1;
            if (isset($permissions['allow'])) {
                foreach ($permissions['allow'] as $key => $permission) {
                    $permissionsValues = ['----' => '----'];
                    if (isset($resources[$permission['resource']])) {
                        foreach ($resources[$permission['resource']] as $perm) {
                            $permissionsValues[$perm] = $perm;
                        }
                    }

                    $fields[2]['resource_cur_' . $i] = [
                        'type' => 'select',
                        'label' => '&nbsp;',
                        'value' => $resourceValues,
                        'attributes' => [
                            'style' => 'display: block; margin-right: 5px; margin-bottom: 5px; width: 200px;',
                        ],
                        'marked' => $permission['resource']
                    ];
                    $fields[2]['permission_cur_' . $i] = [
                        'type' => 'select',
                        'value' => $permissionsValues,
                        'attributes' => [
                            'style' => 'display: block; margin-bottom: 5px;'
                        ],
                        'marked' => $permission['permission']
                    ];
                    $fields[2]['allow_cur_' . $i] = [
                        'type' => 'select',
                        'value' => [
                            '----' => '----',
                            '0' => 'deny',
                            '1' => 'allow'
                        ],
                        'attributes' => [
                            'style' => 'display: block; margin-bottom: 5px;'
                        ],
                        'marked' => 1
                    ];
                    $fields[2]['rm_resources_' . $i] = [
                        'type' => 'checkbox',
                        'value' => [
                            $i => '&nbsp;'
                        ]
                    ];
                    $i++;
                }
            }
            if (isset($permissions['deny'])) {
                foreach ($permissions['deny'] as $key => $permission) {
                    $permissionsValues = ['----' => '----'];
                    if (isset($resources[$permission['resource']])) {
                        foreach ($resources[$permission['resource']] as $perm) {
                            $permissionsValues[$perm] = $perm;
                        }
                    }

                    $fields[2]['resource_cur_' . $i] = [
                        'type' => 'select',
                        'label' => '&nbsp;',
                        'value' => $resourceValues,
                        'attributes' => [
                            'style' => 'display: block; margin-right: 5px; margin-bottom: 5px; width: 200px;',
                        ],
                        'marked' => $permission['resource']
                    ];
                    $fields[2]['permission_cur_' . $i] = [
                        'type' => 'select',
                        'value' => $permissionsValues,
                        'attributes' => [
                            'style' => 'display: block; margin-bottom: 5px;'
                        ],
                        'marked' => $permission['permission']
                    ];
                    $fields[2]['allow_cur_' . $i] = [
                        'type' => 'select',
                        'value' => [
                            '----' => '----',
                            '0' => 'deny',
                            '1' => 'allow'
                        ],
                        'attributes' => [
                            'style' => 'display: block; margin-bottom: 5px;'
                        ],
                        'marked' => 0
                    ];
                    $fields[2]['rm_resources_' . $i] = [
                        'type' => 'checkbox',
                        'value' => [
                            $i => '&nbsp;'
                        ]
                    ];
                    $i++;
                }
            }
        }

        parent::__construct($fields, $action, $method);

        $this->setAttribute('id', 'user-role-form');
        $this->setIndent('    ');
    }

}