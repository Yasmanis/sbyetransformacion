<template>sdfsdfgsfd</template>

<script setup>
defineOptions({
    name: "Notification",
});

Echo.channel("push-message").listen("PushMessage", (e) => {
    alert("Show without refresh!");
    console.log(e.message);
});
</script>
