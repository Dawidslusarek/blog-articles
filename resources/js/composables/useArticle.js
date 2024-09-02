import { ref, computed, onMounted } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import moment from "moment";

export function useArticle() {
    const page = usePage();
    const modalShown = ref(false);
    const comments = ref([]);
    const form = useForm({
        user_id: "",
        article_slug: "",
        body: "",
    });

    const user = computed(() => page.props.auth.user);
    const article = computed(() => page.props.article);

    const handleModal = () => {
        clearFormData();
        form.user_id = user.value.id;
        form.article_slug = article.value.slug;
        modalShown.value = !modalShown.value;
    };

    const formatDate = (date) => {
        return moment(date).format("llll");
    };

    const clearFormData = () => {
        form.article_slug = "";
        form.body = "";
    };

    const submit = async () => {
        handleStoreRequest();
    };

    const handleStoreRequest = async () => {
        try {
            const req = axios.post(
                `/api/articles/${article.value.slug}/comments`,
                form.data()
            );
            const res = await req;

            if (res.status === 201) {
                clearFormData();
                handleModal();
                await fetchComments();
            }
        } catch (e) {
            console.log(e.response.data);
        }
    };

    const fetchComments = async () => {
        const request = await axios.get(
            `/api/articles/${article.value.slug}/comments`
        );
        comments.value = request.data;
    };
    onMounted(fetchComments);

    return {
        user,
        article,
        modalShown,
        form,
        handleModal,
        submit,
        formatDate,
        comments,
    };
}
