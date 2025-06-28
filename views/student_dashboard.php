<?php include '../includes/header.php'; ?>
<?php include '../includes/sidebar.php'; ?>


        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, Welcome Student!</h4>
                    <p class="mb-0">Your Exercise Dashboard</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">App</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Student Dashboard</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <!-- Widgets for Exercise Summary -->
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card bg-primary">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="fas fa-tasks"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1">Total Exercises</p>
                                <h3 class="text-white" id="totalExercises">0</h3>
                                <div class="progress mb-2 bg-secondary">
                                    <div class="progress-bar progress-animated bg-light" style="width: 0%"></div>
                                </div>
                                <small>Overall exercises submitted</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card bg-success">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="fas fa-check-circle"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1">Approved Exercises</p>
                                <h3 class="text-white" id="approvedExercises">0</h3>
                                <div class="progress mb-2 bg-secondary">
                                    <div class="progress-bar progress-animated bg-light" style="width: 0%"></div>
                                </div>
                                <small>Exercises approved by mentor</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card bg-danger">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="fas fa-times-circle"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1">Rejected Exercises</p>
                                <h3 class="text-white" id="rejectedExercises">0</h3>
                                <div class="progress mb-2 bg-secondary">
                                    <div class="progress-bar progress-animated bg-light" style="width: 0%"></div>
                                </div>
                                <small>Exercises rejected by mentor</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card bg-info">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="fas fa-upload"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1">Upload Exercise</p>
                                <h3 class="text-white">New</h3>
                                <div class="progress mb-2 bg-secondary">
                                    <div class="progress-bar progress-animated bg-light" style="width: 100%"></div>
                                </div>
                                <small>Submit a new exercise</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Upload Exercise</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="file-tab" data-bs-toggle="tab" href="#fileUpload" role="tab" aria-controls="fileUpload" aria-selected="true">Upload as File</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="github-tab" data-bs-toggle="tab" href="#githubRepo" role="tab" aria-controls="githubRepo" aria-selected="false">Upload as GitHub Repo</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="fileUpload" role="tabpanel" aria-labelledby="file-tab">
                                    <form id="fileUploadForm" enctype="multipart/form-data">
                                        <input type="hidden" name="student_id" id="studentIdFile" value="">
                                        <div class="mb-3 mt-3">
                                            <label class="form-label">Subject</label>
                                            <select class="form-control" name="subject" required>
                                                <option value="">Select Subject</option>
                                                <option value="PHP">PHP</option>
                                                <option value="JavaScript">JavaScript</option>
                                                <option value="HTML/CSS">HTML/CSS</option>
                                                <option value="Python">Python</option>
                                                <option value="Java">Java</option>
                                                <option value="C#">C#</option>
                                                <option value="Ruby">Ruby</option>
                                                <option value="Go">Go</option>
                                                <option value="Swift">Swift</option>
                                                <option value="Kotlin">Kotlin</option>
                                                <option value="React">React</option>
                                                <option value="Angular">Angular</option>
                                                <option value="Vue.js">Vue.js</option>
                                                <option value="Node.js">Node.js</option>
                                                <option value="Laravel">Laravel</option>
                                                <option value="Django">Django</option>
                                                <option value="Spring Boot">Spring Boot</option>
                                                <option value="ASP.NET">ASP.NET</option>
                                                <option value="MySQL">MySQL</option>
                                                <option value="PostgreSQL">PostgreSQL</option>
                                                <option value="MongoDB">MongoDB</option>
                                                <option value="Docker">Docker</option>
                                                <option value="Kubernetes">Kubernetes</option>
                                                <option value="AWS">AWS</option>
                                                <option value="Azure">Azure</option>
                                                <option value="Google Cloud">Google Cloud</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Notes</label>
                                            <textarea class="form-control" name="note" rows="4"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Upload Files</label>
                                            <div id="file-uploader" class="dropzone">
                                                <div class="dz-message needsclick">
                                                    <i class="fas fa-cloud-upload-alt fa-3x"></i>
                                                    <h4>Drag and drop your files here or click to upload.</h4>
                                                    <span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
                                                </div>
                                            </div>
                                            <div id="file-previews" class="mt-3"></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Exercise</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="githubRepo" role="tabpanel" aria-labelledby="github-tab">
                                    <form id="githubUploadForm">
                                        <input type="hidden" name="student_id" id="studentIdGithub" value="">
                                        <div class="mb-3 mt-3">
                                            <label class="form-label">Subject</label>
                                            <select class="form-control" name="subject" required>
                                                <option value="">Select Subject</option>
                                                <option value="PHP">PHP</option>
                                                <option value="JavaScript">JavaScript</option>
                                                <option value="HTML/CSS">HTML/CSS</option>
                                                <option value="Python">Python</option>
                                                <option value="Java">Java</option>
                                                <option value="C#">C#</option>
                                                <option value="Ruby">Ruby</option>
                                                <option value="Go">Go</option>
                                                <option value="Swift">Swift</option>
                                                <option value="Kotlin">Kotlin</option>
                                                <option value="React">React</option>
                                                <option value="Angular">Angular</option>
                                                <option value="Vue.js">Vue.js</option>
                                                <option value="Node.js">Node.js</option>
                                                <option value="Laravel">Laravel</option>
                                                <option value="Django">Django</option>
                                                <option value="Spring Boot">Spring Boot</option>
                                                <option value="ASP.NET">ASP.NET</option>
                                                <option value="MySQL">MySQL</option>
                                                <option value="PostgreSQL">PostgreSQL</option>
                                                <option value="MongoDB">MongoDB</option>
                                                <option value="Docker">Docker</option>
                                                <option value="Kubernetes">Kubernetes</option>
                                                <option value="AWS">AWS</option>
                                                <option value="Azure">Azure</option>
                                                <option value="Google Cloud">Google Cloud</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Notes</label>
                                            <textarea class="form-control" name="note" rows="4"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">GitHub Repository Link</label>
                                            <input type="url" class="form-control" name="github_repo_link" placeholder="e.g., https://github.com/username/repo-name" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Exercise</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<!-- Include Dropzone.js CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">