<style>
/* Custom Scrollbar Global Koperasi Ugoro */
/* Berlaku untuk seluruh halaman user */
::-webkit-scrollbar { 
    width: 6px; 
    height: 6px; 
}
::-webkit-scrollbar-track { 
    background: transparent; 
}
/* Untuk dark mode dan light mode */
:is(.dark) ::-webkit-scrollbar-track {
    background: transparent;
}
::-webkit-scrollbar-thumb { 
    background: #cbd5e1; 
    border-radius: 10px; 
}
:is(.dark) ::-webkit-scrollbar-thumb {
    background: #334155;
}
::-webkit-scrollbar-thumb:hover { 
    background: #13ec5b; /* Tema Hijau */
}

/* Base body behavior */
html {
    scrollbar-gutter: stable; /* Mencegah loncat saat scrollbar muncul/hilang */
}
</style>
