<script id="member-listing" type="x-template">

    <input type="text" v-model="search" placeholder="Start typing any of the fields below to search....">
    <table width="100%">
        <tr>
            <th class="sort-field"
                v-repeat="column: memberColumns"
                v-on="click: sortBy(column.field)"
                v-class="active-field: sortKey==column.field">
                @{{ column.title }}
            </th>
        </tr>
        <tr v-repeat="member: members
                        | filterBy search
                        | orderBy sortKey reverse"
        >
            <td><img v-attr="src:member | getAvatar '20'"> <a href="@{{ member.url }}" v-text="member | nameFormat"></a></td>
            <td v-text="member.department_name"></td>
            <td v-text="member.role"></td>
            <td><a href="mailto:@{{ email }}" v-text="member.email"></a></td>
            <td v-text="member.telephone"></td>
            <td v-text="member.extension"></td>
            <td v-text="member.skype_name"></td>
        </tr>
    </table>

</script>

<member_listing></member_listing>




