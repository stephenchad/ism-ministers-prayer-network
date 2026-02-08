   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Group: <?php echo e($group->title); ?> - ISM Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background-color: #f4f7f6; }
        .content-card { background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .nav-pills .nav-link { color: #555; }
        .nav-pills .nav-link.active { background-color: #667eea; color: white; }
        .list-group-item { border-left: 0; border-right: 0; }
        .list-group-item:first-child { border-top-left-radius: 0; border-top-right-radius: 0; border-top: 0; }
        .list-group-item:last-child { border-bottom-left-radius: 0; border-bottom-right-radius: 0; border-bottom: 0; }
        .member-actions .btn { display: none; }
        .list-group-item:hover .member-actions .btn { display: inline-block; }
        .photo-card { position: relative; }
        .photo-card .delete-btn { position: absolute; top: 5px; right: 5px; display: none; }
        .photo-card:hover .delete-btn { display: block; }
        .list-group-item .actions { visibility: hidden; }
        .list-group-item:hover .actions { visibility: visible; }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1 fw-bold">Manage Group</h2>
                <p class="mb-0 text-muted">Detailed view and management for "<?php echo e($group->title); ?>"</p>
            </div>
            <a href="<?php echo e(route('admin.groups')); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Back to All Groups</a>
        </div>

        <?php if(Session::has('success')): ?>
            <div class="alert alert-success"><?php echo e(Session::get('success')); ?></div>
        <?php endif; ?>
        <?php if(Session::has('error')): ?>
            <div class="alert alert-danger"><?php echo e(Session::get('error')); ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-4">
                <div class="content-card p-4 mb-4">
                    <h4 class="fw-bold"><?php echo e($group->title); ?></h4>
                    <p class="text-muted"><?php echo e($group->description); ?></p>
                    <hr>
                    <p><i class="fas fa-user-shield me-2 text-primary"></i><strong>Coordinator:</strong> <?php echo e($group->user->name); ?></p>
                    <p><i class="fas fa-sitemap me-2 text-primary"></i><strong>Category:</strong> <?php echo e($group->category->name); ?></p>
                    <p><i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>Location:</strong> <?php echo e($group->city->name ?? 'N/A'); ?>, <?php echo e($group->country->name ?? 'N/A'); ?></p>
                    <p><i class="fas fa-users me-2 text-primary"></i><strong>Members:</strong> <?php echo e($group->current_members); ?> / <?php echo e($group->max_members); ?></p>
                    <p><i class="fas fa-calendar-alt me-2 text-primary"></i><strong>Created:</strong> <?php echo e($group->created_at->format('M d, Y')); ?></p>
                </div>

                <div class="content-card p-4">
                    <h5 class="fw-bold mb-3">Transfer Coordinator</h5>
                    <form action="<?php echo e(route('admin.groups.transferCoordinator')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>">
                        <div class="mb-3">
                            <label for="new_owner_id" class="form-label">Select New Coordinator</label>
                            <select name="new_owner_id" id="new_owner_id" class="form-select" required>
                                <option value="">-- Select a member --</option>
                                <?php $__currentLoopData = $sortedMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($member->id !== $group->user_id): ?>
                                        <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Are you sure you want to transfer ownership? This action cannot be undone.')">Transfer Ownership</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="content-card">
                    <div class="p-3">
                        <ul class="nav nav-pills" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="members-tab" data-bs-toggle="tab" data-bs-target="#members" type="button" role="tab">Members (<?php echo e($group->members->count()); ?>)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="discussions-tab" data-bs-toggle="tab" data-bs-target="#discussions" type="button" role="tab">Discussions (<?php echo e($group->discussions->count()); ?>)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="events-tab" data-bs-toggle="tab" data-bs-target="#events" type="button" role="tab">Events (<?php echo e($group->events->count()); ?>)</button>
                            </li>
                             <li class="nav-item" role="presentation">
                                <button class="nav-link" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos" type="button" role="tab">Photos (<?php echo e($group->photos->count()); ?>)</button>
                            </li>
                             <li class="nav-item" role="presentation">
                                <button class="nav-link" id="resources-tab" data-bs-toggle="tab" data-bs-target="#resources" type="button" role="tab">Resources (<?php echo e($group->resources->count()); ?>)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="rules-tab" data-bs-toggle="tab" data-bs-target="#rules" type="button" role="tab">Rules (<?php echo e($group->rules->count()); ?>)</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content p-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="members" role="tabpanel">
                            <div class="mb-3">
                                <input type="text" id="memberSearch" class="form-control" placeholder="Search for members by name...">
                            </div>
                            <ul class="list-group list-group-flush" id="memberList">
                                <?php $__currentLoopData = $sortedMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center member-item">
                                        <div>
                                            <img src="<?php echo e($member->getImageUrl()); ?>" class="rounded-circle me-2" width="40" height="40">
                                            <strong><?php echo e($member->name); ?></strong>
                                            <?php if($group->user_id == $member->id): ?>
                                                <span class="badge bg-primary ms-2">Owner</span>
                                            <?php elseif($group->leaders->contains($member->id)): ?>
                                                <span class="badge bg-success ms-2">Leader</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="member-actions">
                                            <?php if($group->user_id != $member->id): ?>
                                                <?php if($group->leaders->contains($member->id)): ?>
                                                    <form action="<?php echo e(route('admin.groups.demoteLeader')); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>">
                                                        <input type="hidden" name="user_id" value="<?php echo e($member->id); ?>">
                                                        <button type="submit" class="btn btn-sm btn-secondary">Demote</button>
                                                    </form>
                                                <?php else: ?>
                                                    <form action="<?php echo e(route('admin.groups.promoteLeader')); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>">
                                                        <input type="hidden" name="user_id" value="<?php echo e($member->id); ?>">
                                                        <button type="submit" class="btn btn-sm btn-success">Promote</button>
                                                    </form>
                                                <?php endif; ?>
                                                <form action="<?php echo e(route('admin.groups.removeMember')); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>">
                                                    <input type="hidden" name="user_id" value="<?php echo e($member->id); ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this member?')">Remove</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="discussions" role="tabpanel">
                            <?php if($group->discussions->isNotEmpty()): ?>
                                <ul class="list-group list-group-flush">
                                <!-- No "Add Discussion" as admin. Discussions are user-generated. -->
                                <?php $__currentLoopData = $group->discussions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discussion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1"><?php echo e($discussion->user->name); ?></h6>
                                            <small><?php echo e($discussion->created_at->diffForHumans()); ?></small>
                                        </div>
                                        <div>
                                            <p class="mb-1"><?php echo e($discussion->content); ?></p>
                                            <small class="text-muted"><?php echo e($discussion->replies->count()); ?> replies</small>
                                        </div>
                                        <form action="<?php echo e(route('admin.groups.discussion.destroy')); ?>" method="POST" class="ms-3 actions">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="discussion_id" value="<?php echo e($discussion->id); ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this discussion and all its replies?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-center text-muted p-4">No discussions yet.</p>
                            <?php endif; ?>
                        </div>
                        <div class="tab-pane fade" id="events" role="tabpanel">
                            <div class="text-end mb-3">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addEventModal"><i class="fas fa-plus me-1"></i> Add Event</button>
                            </div>
                            <?php if($group->events->isNotEmpty()): ?>
                                <ul class="list-group list-group-flush">
                                <?php $__currentLoopData = $group->events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <?php if($event->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $event->image)); ?>" alt="<?php echo e($event->title); ?>" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                            <?php endif; ?>
                                            <div>
                                                <h6 class="mb-1"><?php echo e($event->title); ?></h6>
                                                <p class="mb-1 text-muted"><?php echo e(Str::limit($event->description, 50)); ?></p>
                                                <small class="text-muted">On: <?php echo e(\Carbon\Carbon::parse($event->event_date)->format('M d, Y H:i A')); ?></small>
                                            </div>
                                        </div>
                                        <div class="actions">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editEventModal-<?php echo e($event->id); ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="<?php echo e(route('admin.groups.event.destroy')); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="event_id" value="<?php echo e($event->id); ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this event?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-center text-muted p-4">No group-specific events.</p>
                            <?php endif; ?>
                        </div>
                         <div class="tab-pane fade" id="photos" role="tabpanel">
                            <div class="text-end mb-3">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPhotoModal"><i class="fas fa-plus me-1"></i> Add Photo</button>
                            </div>
                            <?php if($group->photos->isNotEmpty()): ?>
                                <div class="row g-2">
                                <?php $__currentLoopData = $group->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 photo-card">
                                        <img src="<?php echo e(asset('storage/' . $photo->path)); ?>" class="img-fluid rounded">
                                        <form action="<?php echo e(route('admin.groups.photo.destroy')); ?>" method="POST" class="delete-btn">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="photo_id" value="<?php echo e($photo->id); ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this photo?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <p class="text-center text-muted p-4">No photos shared in this group.</p>
                            <?php endif; ?>
                        </div>
                         <div class="tab-pane fade" id="resources" role="tabpanel">
                            <div class="text-end mb-3">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addResourceModal"><i class="fas fa-plus me-1"></i> Add Resource</button>
                            </div>
                            <?php if($group->resources->isNotEmpty()): ?>
                                <ul class="list-group list-group-flush">
                                <?php $__currentLoopData = $group->resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="<?php echo e($resource->link ?: asset('storage/' . $resource->file_path)); ?>" target="_blank"><?php echo e($resource->title); ?></a>
                                            <p class="mb-0 text-muted"><?php echo e($resource->description); ?></p>
                                        </div>
                                        <form action="<?php echo e(route('admin.groups.resource.destroy')); ?>" method="POST" class="ms-3 actions">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="resource_id" value="<?php echo e($resource->id); ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this resource?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-center text-muted p-4">No resources shared in this group.</p>
                            <?php endif; ?>
                        </div>
                        <div class="tab-pane fade" id="rules" role="tabpanel">
                            <div class="text-end mb-3">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRuleModal"><i class="fas fa-plus me-1"></i> Add Rule</button>
                            </div>
                            <?php if($group->rules->isNotEmpty()): ?>
                                <ol class="list-group list-group-numbered">
                                <?php $__currentLoopData = $group->rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <?php echo e($rule->rule); ?>

                                        </div>
                                        <div class="actions">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editRuleModal-<?php echo e($rule->id); ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="<?php echo e(route('admin.groups.rule.destroy')); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="rule_id" value="<?php echo e($rule->id); ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this rule?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ol>
                            <?php else: ?>
                                <p class="text-center text-muted p-4">No rules have been set for this group.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Photo Modal -->
    <div class="modal fade" id="addPhotoModal" tabindex="-1" aria-labelledby="addPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPhotoModalLabel">Add New Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.groups.photo.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo File</label>
                            <input type="file" class="form-control" id="photo" name="photo" required accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="caption" class="form-label">Caption (Optional)</label>
                            <input type="text" class="form-control" id="caption" name="caption" placeholder="Enter a caption for the photo">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload Photo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Resource Modal -->
    <div class="modal fade" id="addResourceModal" tabindex="-1" aria-labelledby="addResourceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addResourceModalLabel">Add New Resource</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.groups.resource.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required placeholder="e.g., Weekly Study Guide">
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">URL / Link</label>
                            <input type="url" class="form-control" id="link" name="link" required placeholder="https://example.com/resource">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description (Optional)</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Resource</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Rule Modal -->
    <div class="modal fade" id="addRuleModal" tabindex="-1" aria-labelledby="addRuleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRuleModalLabel">Add New Rule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.groups.rule.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rule_text" class="form-label">Rule</label>
                            <textarea class="form-control" id="rule_text" name="rule" rows="3" required placeholder="Enter the group rule..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Rule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Rule Modals -->
    <?php $__currentLoopData = $group->rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editRuleModal-<?php echo e($rule->id); ?>" tabindex="-1" aria-labelledby="editRuleModalLabel-<?php echo e($rule->id); ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRuleModalLabel-<?php echo e($rule->id); ?>">Edit Rule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.groups.rule.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="rule_id" value="<?php echo e($rule->id); ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_rule_text_<?php echo e($rule->id); ?>" class="form-label">Rule</label>
                            <textarea class="form-control" id="edit_rule_text_<?php echo e($rule->id); ?>" name="rule" rows="3" required><?php echo e($rule->rule); ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Rule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.groups.event.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="group_id" value="<?php echo e($group->id); ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="event_title" class="form-label">Event Title</label>
                            <input type="text" class="form-control" id="event_title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="event_image" class="form-label">Event Image (Optional)</label>
                            <input type="file" class="form-control" id="event_image" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="event_description" class="form-label">Description</label>
                            <textarea class="form-control" id="event_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="event_date" class="form-label">Date and Time</label>
                            <input type="datetime-local" class="form-control" id="event_date" name="event_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="event_location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="event_location" name="location">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Event Modals -->
    <?php $__currentLoopData = $group->events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editEventModal-<?php echo e($event->id); ?>" tabindex="-1" aria-labelledby="editEventModalLabel-<?php echo e($event->id); ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel-<?php echo e($event->id); ?>">Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.groups.event.update')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="event_id" value="<?php echo e($event->id); ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_event_title_<?php echo e($event->id); ?>" class="form-label">Event Title</label>
                            <input type="text" class="form-control" id="edit_event_title_<?php echo e($event->id); ?>" name="title" value="<?php echo e($event->title); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_event_image_<?php echo e($event->id); ?>" class="form-label">Event Image (Optional)</label>
                            <input type="file" class="form-control" id="edit_event_image_<?php echo e($event->id); ?>" name="image" accept="image/*">
                            <?php if($event->image): ?>
                                <img src="<?php echo e(asset('storage/' . $event->image)); ?>" alt="Current Image" class="img-thumbnail mt-2" width="100">
                                <small class="d-block text-muted">Current image. Upload a new one to replace it.</small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="edit_event_description_<?php echo e($event->id); ?>" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_event_description_<?php echo e($event->id); ?>" name="description" rows="3"><?php echo e($event->description); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_event_date_<?php echo e($event->id); ?>" class="form-label">Date and Time</label>
                            <input type="datetime-local" class="form-control" id="edit_event_date_<?php echo e($event->id); ?>" name="event_date" value="<?php echo e(\Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i')); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_event_location_<?php echo e($event->id); ?>" class="form-label">Location</label>
                            <input type="text" class="form-control" id="edit_event_location_<?php echo e($event->id); ?>" name="location" value="<?php echo e($event->location); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('memberSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    const filter = searchInput.value.toLowerCase().trim();
                    const memberList = document.getElementById('memberList');
                    const members = memberList.getElementsByClassName('member-item');

                    for (let i = 0; i < members.length; i++) {
                        const memberItem = members[i];
                        const memberName = memberItem.getElementsByTagName("strong")[0];
                        if (memberName) {
                            const nameText = memberName.textContent.toLowerCase();
                            if (nameText.indexOf(filter) > -1) {
                                memberItem.style.display = "";
                            } else {
                                memberItem.style.display = "none";
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/groups/show.blade.php ENDPATH**/ ?>