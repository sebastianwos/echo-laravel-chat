<template>
    <div class="flex">
        <div class="flex-item conversation">
            <div v-for="event in messages">
                <b>{{ event.user == null ? 'Guest' : event.user.name }} - {{ event.created_at }}</b>
                <p>
                    {{ event.message }}
                </p>
            </div>
            <textarea name="message" v-model="message" v-on:keyup.enter="sendMessage"></textarea>
        </div>
        <div class="flex-item people">
            <h4>Logged in users:</h4>
            <p v-for="user in users">{{ user.name }}</p>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['apiToken'],
        activate: function (done) {
            var self = this;
            this.$http.get('api/messages')
                .then(function(response){
                    self.messages = response.data;
                    console.log('Messages loaded ...');
                    done();
                });
        },
        data: function(){
            return {
                users: {},
                message: null,
                messages: []
            }
        },
        ready: function(){
            var self = this;
            Echo.channel('chat-room')
                    .listen('ChatMessageWasReceived', function(e){
                        self.$emit('message-received', e);
                    });
            Echo.join('chat-room')
                .here(function (members) {
                    var users = {};
                    for(var member in members){
                        users[members[member].id] = {name: members[member].name};
                    }
                    self.users = Object.assign({}, self.users, users);
                    console.log('Already on channel ...');
                })
                .joining(function (joiningMember, members) {
                    // runs when another member joins
                    var user = {};
                    user[joiningMember.id] = {name: joiningMember.name};
                    self.users = Object.assign({}, self.users, user);
                    console.log('Joining channel ...');
                })
                .leaving(function (leavingMember, members) {
                    // runs when another member leaves
                    delete self.users[leavingMember.id];
                    self.users = Object.assign({}, self.users);
                    console.log('Leaving channel ...');
                });
        },
        events: {
            'message-received': function(e){
                this.messages.push({user: e.user, message: e.chatMessage.message, created_at: e.chatMessage.created_at});
            }
        },
        methods: {
            sendMessage: function () {
                var self = this;
                this.$http.post('api/message?api_token='+self.apiToken, { message: self.message })
                    .then(function(){
                        self.message = null;
                        console.log('Message sent ...');
                    });
            }
        }

    }
</script>
