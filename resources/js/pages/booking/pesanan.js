window.switchTab = function(tab) {
    const tabs = ['menunggu', 'diproses', 'selesai', 'dibatalkan'];
    
    tabs.forEach(t => {
        const btn = document.getElementById(t + 'Btn');
        const list = document.getElementById(t + 'List');
        
        if (t === tab) {
            if(list) {
                list.classList.remove('hidden');
                list.classList.add('block');
            }
            if(btn) {
                btn.classList.add('text-accent', 'border-accent', 'font-bold');
                btn.classList.remove('text-gray-400', 'border-transparent', 'font-semibold');
            }
        } else {
            if(list) {
                list.classList.add('hidden');
                list.classList.remove('block');
            }
            if(btn) {
                btn.classList.remove('text-accent', 'border-accent', 'font-bold');
                btn.classList.add('text-gray-400', 'border-transparent', 'font-semibold');
            }
        }
    });
};
