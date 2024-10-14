<x-layouts.app>
    <div class="grid grid-cols-3 gap-6">
        {{-- chamando componente livewire que exibe o projeto --}}
        <livewire:projects.show :$project />
        {{-- chamando componente livewire que exibre as propostas --}}
        <livewire:projects.proposals :$project />
    </div>
</x-layouts.app>