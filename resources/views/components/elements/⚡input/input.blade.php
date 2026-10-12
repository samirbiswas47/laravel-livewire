<div>
    @if(in_array($type, ['text', 'number', 'email', 'password']))
        <div class="w-100 flex justify-between col-span-{{$colspan}} px-2">
            <label for="{{ $id }}" class="w-30 font-medium">{{ $title }} @if($required=="true"  || $required === true) <small class="text-red-500">* </small> @endif</label>
            <input
                wire:model.live="value"
                type="{{ $type }}"
                id="{{ $id }}"
                name="{{ $name }}"
                class="border border-gray-300 focus:border-green-500 focus:outline focus:outline-sky-500 rounded-sm py-2 pl-2 w-70 {{ $class }}"
                autocomplete="do-not-autofill"

                @if($type === "number" && $min !== "") min="{{ $min }}" @endif
                @if($type === "number" && $max !== "") max="{{ $max }}" @endif
            />
        </div>
    @elseif($type === "checkbox" || $type === "radio")
        <div class="w-100 flex justify-start col-span-1 px-2">
            <lable class="w-30 font-medium">{{$title}} @if($required=="true"  || $required === true) <small class="text-red-500">* </small> @endif</lable>
            <div class="w-70 flex justify-start text-center">
                @foreach ($options as $key=>$val)
                    <input for="{{ $id }}-{{ $key }}"  wire:model="value"  class="left-0 w-4 {{$class}} cursor-pointer" type="{{$type}}" id="{{ $id }}-{{ $key }}" name="{{ $type === 'checkbox' ? ($name ?: $id).'[]' : ($name ?: $id) }}" value="{{ $key }}" />
                    <lable class="px-1 text-muted" for="{{ $id }}-{{ $key }}">{{$val}}</lable>
                @endforeach
            </div>
        </div>
    @elseif($type === "textarea")
        <div class="w-100 flex justify-between col-span-{{$colspan}} px-2" wire:ignore>
            <lable for="{{ $id }}" class="font-medium @if ($colspan=="2") w-15 @else w-30 @endif">{{$title}} @if($required=="true"  || $required === true) <small class="text-red-500">* </small> @endif </lable>

            <textarea wire:model="value" class="@if ($colspan=="2") w-85 @else w-70 @endif border border-gray-300 focus:border-green-500 focus:outline focus:outline-sky-500 rounded-sm py-2 pl-2  {{$class}}" type="{{$type}}" id="{{$id}}" name="{{$name}}"  rows="{{$rows}}" cols="{{$cols}}"></textarea>
        </div>
    @elseif($type === "select")
        <div class="w-100 flex justify-between col-span-{{$colspan}} px-2" wire:ignore>
            <lable for="{{ $id }}" class="font-medium @if ($colspan=="2") w-15 @else w-30 @endif">{{$title}} @if($required=="true"  || $required === true) <small class="text-red-500">* </small> @endif </lable>

            <select
                wire:model.live="value"
                id="{{ $id }}"
                name="{{ $isMulti ? ($name ?: $id).'[]' : ($name ?: $id) }}"
                class="border  border-gray-300 focus:border-green-500 focus:outline focus:outline-sky-500 rounded-sm py-2 pl-2 w-70 {{ $class }}"
                @if($isMulti) multiple @endif
            >
                @if(!$isMulti)
                    <option class="bg-input-bg" value="">Select</option>
                @endif

                @if(!empty($options))
                    @foreach ($options as $key=>$val)
                        <option class="bg-input-bg" value="{{ $key }}" >{{ $val }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    @endif

    {{-- Error message display --}}
    @if(!empty($error))
        <div class="w-full flex justify-end mt-1">
            <span class="@if($type === 'textarea' && $colspan == '2') w-85 @else w-70 @endif text-xs text-red-500 font-semibold">
                {{ $error }}
            </span>
        </div>
    @endif
</div>
