const escapeHtml = (unsafe) => {
    return String(unsafe)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
};

const debounce = (fn, wait = 250) => {
    let t;
    return (...args) => {
        clearTimeout(t);
        t = setTimeout(() => fn(...args), wait);
    };
};

function renderItems(container, items) {
    if (!items || items.length === 0) {
        container.innerHTML =
            '<div class="p-3 text-sm text-slate-600">Geen gebruikers gevonden.</div>';
        return;
    }

    container.innerHTML = items
        .map((item) => {
            const displayName = item.display_name || item.username;
            const avatar = item.avatar_url
                ? `<img src="${escapeHtml(item.avatar_url)}" alt="" class="w-8 h-8 rounded-full object-cover border border-slate-200" loading="lazy" />`
                : `<div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-semibold">${escapeHtml(
                      (item.username || 'U').slice(0, 1).toUpperCase()
                  )}</div>`;

            return `
<a href="${escapeHtml(item.url)}" class="flex items-center gap-3 p-3 hover:bg-emerald-50/60 focus:bg-emerald-50/60 focus:outline-none">
  ${avatar}
  <div class="min-w-0 flex-1">
    <div class="font-medium truncate text-slate-900">${escapeHtml(displayName)}</div>
    <div class="text-sm text-slate-600 truncate">@${escapeHtml(item.username)}</div>
  </div>
  <div class="text-xs text-emerald-700 font-medium">Bekijk →</div>
</a>`;
        })
        .join('');
}

async function fetchSuggestions({ url, q, limit, signal }) {
    const resp = await window.axios.get(url, {
        params: { q, limit },
        signal,
    });
    return resp.data;
}

function initSuggest(root) {
    const input = root.querySelector('[data-user-search-input]');
    const panel = root.querySelector('[data-user-search-panel]');

    if (!input || !panel) return;

    const suggestUrl = input.getAttribute('data-suggest-url');
    const minChars = Number(input.getAttribute('data-min-chars') || 2);
    const limit = Number(input.getAttribute('data-limit') || 6);

    if (!suggestUrl) return;

    let controller = null;

    const hide = () => {
        panel.classList.add('hidden');
        panel.innerHTML = '';
    };

    const show = () => {
        panel.classList.remove('hidden');
    };

    const run = debounce(async () => {
        const q = (input.value || '').trim();

        if (q.length < minChars) {
            hide();
            return;
        }

        if (controller) controller.abort();
        controller = new AbortController();

        panel.innerHTML = '<div class="p-3 text-sm text-slate-600">Zoeken…</div>';
        show();

        try {
            const data = await fetchSuggestions({
                url: suggestUrl,
                q,
                limit,
                signal: controller.signal,
            });

            renderItems(panel, data?.items || []);
            show();
        } catch (e) {
            // Abort is expected when typing fast.
            if (e?.name === 'CanceledError' || e?.name === 'AbortError') {
                return;
            }

            panel.innerHTML =
                '<div class="p-3 text-sm text-slate-600">Kon geen suggesties laden.</div>';
            show();
        }
    }, 250);

    input.addEventListener('input', run);

    // Close when clicking outside.
    document.addEventListener('click', (e) => {
        if (!root.contains(e.target)) hide();
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') hide();
    });
}

export function initUserSearchSuggest() {
    document
        .querySelectorAll('[data-user-search-suggest]')
        .forEach((root) => initSuggest(root));
}

