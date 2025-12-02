@extends('layouts.admin')

@section('title', 'Edit Feedback')
@section('admin-content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Edit Feedback
                    <small class="text-muted">#{{ $feedback->reference_code }}</small>
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.feedback.update', $feedback) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $feedback->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" required>{{ old('description', $feedback->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category & Priority -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $feedback->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select @error('priority') is-invalid @enderror" 
                                    id="priority" name="priority" required>
                                <option value="low" {{ old('priority', $feedback->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', $feedback->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="