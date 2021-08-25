<template>
    <div class="user" @click="onClick" :class="{ selected: selected }">
      <!-- :class="{ selected: selectedUser.user == user }" -->
      <div class="description">
        <div class="name">
          {{ user.username }} {{ user.self ? " (yourself)" : "" }}
        </div>
        <div class="status">
          <i class="icon connected"></i>
          <!-- <status-icon :connected="user.connected" />{{ status }} -->
        </div>
      </div>
      <div v-if="user.hasNewMessages" class="new-messages">!</div>
    </div>
</template>

<script>
export default {
  name: "customer-list",
  props: {
    user: Object,
    selected: Boolean,
  },

  methods:{
      onClick(){
          this.$emit('select')
      }
  }
};
</script>
<style scoped>
icon {
  height: 8px;
  width: 8px;
  border-radius: 50%;
  display: inline-block;
  background-color: #e38968;
  margin-right: 6px;
}

.icon.connected {
  background-color: #86bb71;
}
</style>