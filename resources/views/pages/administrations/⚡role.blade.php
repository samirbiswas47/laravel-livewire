<?php

use Livewire\Component;
use App\Models\Role;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

new class extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public string $icon = '';
    public string $role = '';
    public string $status = '';
    public string $title = 'Add Role';
    public string $id = '';

    // In-memory states (no #[Url] tracking)
    public string $currentFilter = 'list';
    public string $search = '';

    // Sorting state
    public string $sortField = 'role';
    public string $sortDirection = 'asc';

    // Dynamic per-page length property
    public int $perPage = 10;

    // Allowed per-page options
    public array $perPageOptions = [2, 5, 10, 25, 50, 100];

    public array $btnarray = [
        [
            'icon'  => '<i class="fas fa-list"></i>',
            'title' => 'List',
            'color' => 'primary',
        ],
        [
            'icon'  => '<i class="fas fa-trash"></i>',
            'title' => 'Trash',
            'color' => 'danger',
        ],
        [
            'icon'  => '<i class="fas fa-archive"></i>',
            'title' => 'Archive',
            'color' => 'warning',
        ],
    ];

    public array $statusOptions = [
        '1' => 'Active',
        '0' => 'Inactive',
    ];

    public function mount(): void
    {
        $this->dispatch('page-filter', $this->currentFilter);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function clearSearch(): void
    {
        $this->reset('search');
        $this->resetPage();
    }

    #[On('filter-changed')]
    public function handleFilter(string $action): void
    {
        if (in_array($action, ['list', 'trash', 'archive'])) {
            $this->currentFilter = $action;
            $this->resetPage();
            $this->dispatch('page-filter', $this->currentFilter);
        }
    }

    /**
     * Handle column sorting toggles.
     */
    #[On('filter-sort-by')]
    public function sortBy(string $field): void
    {
        // Protect against invalid columns
        $allowedFields = ['role', 'status', 'created_at', 'updated_at', 'deleted_at', 'id'];
        if (!in_array($field, $allowedFields)) {
            return;
        }

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->dispatch('prop-data',[$this->sortField, $this->sortDirection]);
        $this->resetPage();
    }


    #[Computed]
    public function roles(): LengthAwarePaginator
    {
        $query = match ($this->currentFilter) {
            'trash'   => Role::onlyTrashed(),
            'archive' => Role::where('status', 2),
            default   => Role::where('status', '!=', 2),
        };

        return $query
            ->when(filled($this->search), function ($q) {
                $term = '%' . trim($this->search) . '%';

                $q->where(function ($sub) use ($term) {
                    $sub->where('role', 'like', $term);

                    if (is_numeric(trim($this->search))) {
                        $sub->orWhere('status', (int) trim($this->search));
                    }
                });
            })
            // Dynamic order by selected column & direction
            ->when(in_array($this->sortField, ['created_at', 'updated_at', 'deleted_at'], true), function ($q) {
                // Strictly validate direction to prevent raw SQL injection
                $direction = strtolower($this->sortDirection) === 'desc' ? 'DESC' : 'ASC';
                // Pushes NULL values to the end for both ASC and DESC sorts
                $q->orderByRaw("{$this->sortField} IS NULL, {$this->sortField} {$direction}");
            }, function ($q) {
                $q->orderBy($this->sortField, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    #[On('open-create-user')]
    public function create(): void
    {
        $this->resetForm();
        $this->resetValidation();
        $this->dispatch('open-modal', title: 'Add Role');
    }

    #[On('edit-role')]
    public function edit(int $roleId): void
    {
        $this->resetValidation();
        $role = Role::findOrFail($roleId);
        if ($role) {
            $this->id     = (string) $role->id;
            $this->role   = $role->role ?? '';
            $this->status = (string) $role->status;
        }
        $this->dispatch('open-modal', title: 'Edit User');
    }

    public function deleted($id): void
    {
        try {
            $role = Role::withTrashed()->find($id);
            if ($role) {
                $role->forceDelete();
                Toaster::success('Role permanently deleted.');
            }
        } catch (\Throwable $e) {
            Log::error('Delete role error: ' . $e->getMessage());
            Toaster::error('Something went wrong.');
        }
    }

    public function removed($id): void
    {
        try {
            $role = Role::find($id);
            if ($role) {
                $role->delete();
                Toaster::success('Role removed.');
            }
        } catch (\Throwable $e) {
            Log::error('Remove role error: ' . $e->getMessage());
            Toaster::error('Something went wrong.');
        }
    }

    public function archived($id): void
    {
        try {
            $role = Role::find($id);
            if ($role) {
                $role->update(['status' => 2]);
                Toaster::success('Role archived.');
            }
        } catch (\Throwable $e) {
            Log::error('Archive role error: ' . $e->getMessage());
            Toaster::error('Something went wrong.');
        }
    }

    public function unarchived($id): void
    {
        try {
            $role = Role::find($id);
            if ($role) {
                $role->update(['status' => 1]);
                Toaster::success('Role unarchived.');
            }
        } catch (\Throwable $e) {
            Log::error('Unarchive role error: ' . $e->getMessage());
            Toaster::error('Something went wrong.');
        }
    }

    public function restored($id): void
    {
        try {
            $role = Role::withTrashed()->find($id);
            if ($role) {
                $role->restore();
                Toaster::success('Role restored.');
            }
        } catch (\Throwable $e) {
            Log::error('Restore role error: ' . $e->getMessage());
            Toaster::error('Something went wrong.');
        }
    }

    public function save(): void
    {

        $validated = $this->validate([
            'role'   => 'required|string|max:255',
            'status' => 'required|numeric|in:0,1,2',
        ]);


        try {
            if ($this->id == '') {
                Role::create($validated);
                Toaster::success('Role');
            } else {
                $role = Role::findOrFail($this->id);
                $role->update($validated);
                Toaster::success('Role updated.');
            }

            $this->reset(['role', 'status', 'id']);
            $this->dispatch('close-modal');
        } catch (\Throwable $e) {
            Log::error('Save role error: ' . $e->getMessage());
            Toaster::error('Something went wrong.');
        }
    }

    public function resetForm(): void
    {
        $this->reset(['role', 'status', 'id']);
    }
};
?>

<div>
    <div class="my-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <!-- Breadcrumb -->
        <nav class="flex items-center text-xs sm:text-sm text-gray-500 overflow-x-auto no-scrollbar py-0.5" aria-label="Breadcrumb">
            <a href="/dashboard" wire:navigate class="shrink-0 text-gray-400 hover:text-indigo-600 transition">
                Dashboard
            </a>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mx-1.5 sm:mx-2 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="hidden md:inline shrink-0 text-gray-400">Administrations</span>
            <svg class="hidden md:inline w-4 h-4 mx-2 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="shrink-0">Role</span>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mx-1.5 sm:mx-2 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="font-bold shrink-0 text-gray-400">
                {{ ucwords($currentFilter) }}
            </span>
        </nav>

        <!-- Action Buttons -->
        <div class="flex items-center justify-start sm:justify-end">
            <livewire:list-icon-button :btnarray="$btnarray" />
        </div>
    </div>

    <div class="max-h-[82vh] pb-5">
        <div class="bg-surface shadow-lg py-3 px-4">
            <div class="w-full">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>Roles {{ ucwords($currentFilter) }}</div>

                    <div class="flex justify-end gap-2">
                        <!-- Add User Modal Element -->
                        <livewire:elements.modal type="icon" :title="$title" icon="<i class='fas fa-plus'></i>" width="80" size="md">
                            <div class="w-full">
                                <form wire:submit="save" class="w-full py-5 px-4 h-auto" autocomplete="off">
                                    <div class="w-full grid grid-cols-1 gap-6">
                                        <livewire:elements.input wire:model="role" type="text" title="Role" id="role" :required="true" :error="$errors->first('role')" wire:key="field-role-{{ $errors->has('role') }}" colspan="1" />
                                        <livewire:elements.input wire:model="status" type="radio" title="Status" id="status" :options="$statusOptions" :required="true" :error="$errors->first('status')" wire:key="field-status-{{ $errors->has('status') }}" colspan="1" />
                                    </div>
                                    <div class="w-full flex justify-center items-center gap-3 py-2 mt-6 border-t border-gray-200">
                                        <button type="submit" class="px-5 py-2 btn btn-outline-primary rounded">Save</button>
                                        <button type="reset" wire:click="resetForm" class="px-5 py-2 btn btn-outline-warning rounded">Reset</button>
                                        <button @click="show = false" type="button" class="px-5 py-2 btn btn-outline-danger rounded">Close</button>
                                    </div>
                                </form>
                            </div>
                        </livewire:elements.modal>

                        <!-- Search Input -->
                        <div class="relative w-full sm:w-64">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-muted"></i>
                            <input
                                wire:model.live.debounce.300ms="search"
                                type="text"
                                placeholder="Search roles..."
                                class="w-full rounded-lg border border-border bg-input-bg py-2 pl-10 pr-8 text-sm text-heading outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20"
                            >
                            @if(filled($search))
                                <button
                                    type="button"
                                    wire:click="clearSearch"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-vissible bg-surface rounded-md border border-border">
                    <table class="xs:min-w-full sm:min-w-full w-full divide-y text-md">
                        <thead class="bg-background select-none">
                            <tr>
                                <th class="px-4 py-2.5 text-left font-medium" width="40%">
                                    <livewire:sort-table-head theadName="Role" sortName="role" :sortField="$sortField" :sortField="$sortDirection"/>
                                </th>

                                <th class="px-4 py-2.5 text-center font-medium" width="15%">
                                    <livewire:sort-table-head theadName="Status" sortName="status" :sortField="$sortField" :sortField="$sortDirection"/>
                                </th>
                                @if($currentFilter!='trash')
                                <!-- Created At -->
                                <th class="px-4 py-2.5 text-left font-medium" width="15%">
                                    <livewire:sort-table-head theadName="Created At" sortName="created_at" :sortField="$sortField" :sortField="$sortDirection"/>
                                </th>
                                @else
                                <!-- Deleted At -->
                                <th class="px-4 py-2.5 text-left font-medium" width="15%">
                                    <livewire:sort-table-head theadName="Deleted At" sortName="deleted_at" :sortField="$sortField" :sortField="$sortDirection"/>
                                </th>
                                @endif
                                <!-- Updated At -->
                                <th class="px-4 py-2.5 text-left font-medium" width="15%">
                                    <livewire:sort-table-head theadName="Updated At" sortName="updated_at" :sortField="$sortField" :sortField="$sortDirection"/>
                                </th>

                                <!-- Action (Non-sortable) -->
                                <th class="px-4 py-2.5 text-center font-medium" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse ($this->roles as $row)
                                <tr wire:key="role-row-{{ $row->id }}" class="transition hover:bg-item-hover">
                                    <td class="px-4 py-3 font-medium">{{ $row->role }}</td>
                                    <td class="px-4 py-3 text-left">
                                        @if($row->status == 1)
                                            <span class="inline-flex items-center gap-1.5 text-md font-medium text-emerald-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                                            </span>
                                        @elseif($row->status == 3)
                                            <span class="inline-flex items-center gap-1.5 text-md font-medium text-amber-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Archive
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-md font-medium text-danger">
                                                <span class="h-1.5 w-1.5 rounded-full  bg-amber-500"></span> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    @if($currentFilter!='trash')
                                    <td class="px-4 py-3">
                                        {{ $row->created_at?->format('M d, Y H:i:s') }}
                                    </td>
                                    @else
                                    <td class="px-4 py-3">
                                        {{ $row->deleted_at?->format('M d, Y H:i:s')}}
                                    </td>
                                    @endif
                                    <td class="px-4 py-3">
                                        {{ $row->updated_at?->format('M d, Y H:i:s') }}
                                    </td>
                                    <td class="px-4 py-3 text-center relative z-30">
                                        <livewire:dropdown-menu
                                            wire:key="dropdown-row-{{ $row->id }}"
                                            title="click"
                                            type="icon"
                                            icon='<i class="fas fa-ellipsis-v"></i>'
                                            id="dropdown-{{ $row->id }}"
                                            btn="success"
                                            zindex="100"
                                        >
                                            <div class="p-2">
                                                @if($currentFilter === 'list')
                                                    <a href="#" wire:click="$dispatch('edit-role', { roleId: {{ $row->id }} })" class="flex items-center gap-2 px-2 py-1 rounded btn-outline-primary">
                                                        <i class="fa-solid fa-pencil"></i> Edit
                                                    </a>
                                                    <a href="#" wire:click.prevent="archived({{ $row->id }})" class="flex items-center gap-2 px-2 py-1 rounded btn-outline-warning">
                                                        <i class="fa-solid fa-archive"></i> Archive
                                                    </a>
                                                    <a href="#" wire:click.prevent="removed({{ $row->id }})" class="flex items-center gap-2 px-2 py-1 rounded btn-outline-danger">
                                                        <i class="fa-solid fa-trash"></i> Remove
                                                    </a>
                                                @elseif($currentFilter === 'trash')
                                                    <a href="#" wire:click.prevent="restored({{ $row->id }})" class="flex items-center gap-2 px-2 py-1 rounded btn-outline-success">
                                                        <i class="fa-solid fa-undo"></i> Restore
                                                    </a>
                                                    <a href="#" wire:click.prevent="deleted({{ $row->id }})" wire:confirm="Sure to delete forever this record?" class="flex items-center gap-2 px-2 py-1 rounded btn-outline-danger">
                                                        <i class="fa-solid fa-trash"></i> Delete
                                                    </a>
                                                @elseif($currentFilter === 'archive')
                                                    <a href="#" wire:click.prevent="unarchived({{ $row->id }})" class="flex items-center gap-2 px-2 py-1 rounded btn-outline-success">
                                                        <i class="fa-solid fa-undo"></i> Unarchive
                                                    </a>
                                                    <a href="#" wire:click.prevent="removed({{ $row->id }})" class="flex items-center gap-2 px-2 py-1 rounded btn-outline-danger">
                                                        <i class="fa-solid fa-trash"></i> Remove
                                                    </a>
                                                @endif
                                            </div>
                                        </livewire:dropdown-menu>
                                    </td>
                                </tr>
                            @empty
                                <tr wire:key="no-roles-row">
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                        No records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Active Pagination Links -->
                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <!-- Showing Count & Per-Page Controls -->
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <span>Rows per page:</span>
                        <select
                            wire:model.live="perPage"
                            class="rounded-md border border-border bg-input-bg py-1 px-2 text-xs text-heading outline-none focus:border-indigo-500"
                        >
                            @foreach ($perPageOptions as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                        <span>
                            Showing {{ $this->roles->firstItem() ?? 0 }} to {{ $this->roles->lastItem() ?? 0 }} of {{ $this->roles->total() }} entries
                        </span>
                    </div>

                    <!-- Pagination Links -->
                    <div>
                        {{ $this->roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
