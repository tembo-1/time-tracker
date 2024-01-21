import { defineStore } from "pinia";
const meta = document.querySelector('meta[name=authorisation]');
export const useUserStore = defineStore("userStore", {
    state: () => {
        return {
            Auth: !!meta,
            UserData: meta ? {...JSON.parse(meta.content)} : {role: "Guest"},
            CartCount: null,
        };
    },
    actions: {
        async getCartCount(){
            if (this.Auth) {
                try {
                    const response = await axios.get('/cartItems/info');
                    this.CartCount = response.data.count;
                } catch (error) {
                    return null
                }
            }
        },
        Permitted(permission) {
            if (this.Auth) {
                return this.UserData.permissions[permission];
            }
            return false
        }
    }
});
