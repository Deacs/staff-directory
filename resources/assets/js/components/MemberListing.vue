<template>

    <input type="text" v-model="search">
        <table width="100%">
            <tr>
                <th class="sort-field"
                    v-repeat="column: memberColumns"
                    v-on="click: sortBy(column.field)"
                    v-class="active-field: sortKey==column.field">
                    {{ column.title }}
                </th>
            </tr>
            <tr v-repeat="member: members
                        | filterBy search
                        | orderBy sortKey reverse"
            >
                <td><img v-attr="src:member | getAvatar '20'" width="20"> <a href="{{ member.url }}" v-text="member | nameFormat"></a></td>
                    <td v-text="member.department_name"></td>
                    <td v-text="member.role"></td>
                    <td><a href="mailto:{{ email }}" v-text="member.email"></a></td>
                    <td v-text="member.telephone"></td>
                    <td v-text="member.extension"></td>
                    <td v-text="member.skype_name"></td>
                </tr>
            </table>
</template>

<script>

    export default {

        props: [
            'dept_name',
            'dept_slug',
            'location_slug',
            'flashdata',
            'displayflash'
        ],

        data() {

            return {
                memberColumns: [
                    {field: 'last_name', title: 'Name'},
                    {field: 'department_name', title: 'Department'},
                    {field: 'role', title: 'Role'},
                    {field: 'email', title: 'email'},
                    {field: 'telephone', title: 'Telephone'},
                    {field: 'extension', title: 'Extension'},
                    {field: 'skype_name', title: 'Skype'}
                ],
                dept_slug: '',
                dept_name: '',
                location_slug: '',
                departments: [],
                locations: [],
                members: [],
                sortKey: '',
                reverse: false,
                search: '',
                newMember: {
                first_name: '',
                last_name: '',
                slug: '',
                role: '',
                email: '',
                telephone: null,
                extension: null,
                skype_name: null,
                department_id: '',
                department_name: '',
                location_id: ''
            },
            flashdata: {
                'level': '',
                'message': ''
            },

                displayflash: false
            }
        },

        methods: {
            fetchDepartments:   require('../methods/fetchDepartments'),
            fetchLocations:     require('../methods/fetchLocations'),
            fetchMembers:       require('../methods/fetchMembers'),
            addNewMember:       require('../methods/addMember'),
            sortBy:             require('../methods/sortBy'),
            makeSlug:           require('../methods/makeSlug')
        },

        ready: function() {

            var dept        = '';
            var location    = '';

            var bounds = {
                dept       : this.dept_slug,
                location   : this.location_slug
            };

            this.fetchMembers(bounds);
            this.fetchDepartments();
            this.fetchLocations();
        }
    }

</script>
