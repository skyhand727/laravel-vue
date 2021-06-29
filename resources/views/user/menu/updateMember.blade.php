<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--form">
                <user-menu-member-update-component v-bind:member_id="{{ $member_id }}"></user-menu-member-update-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
