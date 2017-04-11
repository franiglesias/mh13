<?php
/*
 * Copyright 2010 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

/**
 * Service definition for Dataflow (v1beta3).
 *
 * <p>
 * Google Dataflow API.</p>
 *
 * <p>
 * For more information about this service, see the API
 * <a href="" target="_blank">Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_Service_Dataflow extends Google_Service
{
  /** View and manage your data across Google Cloud Platform services. */
  const CLOUD_PLATFORM =
      "https://www.googleapis.com/auth/cloud-platform";
  /** View your email address. */
  const USERINFO_EMAIL =
      "https://www.googleapis.com/auth/userinfo.email";

  public $v1b3_projects_jobs;
  public $v1b3_projects_jobs_messages;
  public $v1b3_projects_jobs_workItems;
  

  /**
   * Constructs the internal representation of the Dataflow service.
   *
   * @param Google_Client $client
   */
  public function __construct(Google_Client $client)
  {
    parent::__construct($client);
    $this->servicePath = 'dataflow/v1b3/projects/';
    $this->version = 'v1beta3';
    $this->serviceName = 'dataflow';

    $this->v1b3_projects_jobs = new Google_Service_Dataflow_V1b3ProjectsJobs_Resource(
        $this,
        $this->serviceName,
        'jobs',
        array(
          'methods' => array(
            'create' => array(
              'path' => '{projectId}/jobs',
              'httpMethod' => 'POST',
              'parameters' => array(
                'projectId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'view' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),'get' => array(
              'path' => '{projectId}/jobs/{jobId}',
              'httpMethod' => 'GET',
              'parameters' => array(
                'projectId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'jobId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'view' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),'getMetrics' => array(
              'path' => '{projectId}/jobs/{jobId}/metrics',
              'httpMethod' => 'GET',
              'parameters' => array(
                'projectId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'jobId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'startTime' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),'list' => array(
              'path' => '{projectId}/jobs',
              'httpMethod' => 'GET',
              'parameters' => array(
                'projectId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'pageToken' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'view' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'pageSize' => array(
                  'location' => 'query',
                  'type' => 'integer',
                ),
              ),
            ),'patch' => array(
              'path' => '{projectId}/jobs/{jobId}',
              'httpMethod' => 'PATCH',
              'parameters' => array(
                'projectId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'jobId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'update' => array(
              'path' => '{projectId}/jobs/{jobId}',
              'httpMethod' => 'PUT',
              'parameters' => array(
                'projectId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'jobId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),
          )
        )
    );
    $this->v1b3_projects_jobs_messages = new Google_Service_Dataflow_V1b3ProjectsJobsMessages_Resource(
        $this,
        $this->serviceName,
        'messages',
        array(
          'methods' => array(
            'list' => array(
              'path' => '{projectId}/jobs/{jobId}/messages',
              'httpMethod' => 'GET',
              'parameters' => array(
                'projectId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'jobId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'pageSize' => array(
                  'location' => 'query',
                  'type' => 'integer',
                ),
                'pageToken' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'startTime' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'endTime' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'minimumImportance' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),
          )
        )
    );
    $this->v1b3_projects_jobs_workItems = new Google_Service_Dataflow_V1b3ProjectsJobsWorkItems_Resource(
        $this,
        $this->serviceName,
        'workItems',
        array(
          'methods' => array(
            'lease' => array(
              'path' => '{projectId}/jobs/{jobId}/workItems:lease',
              'httpMethod' => 'POST',
              'parameters' => array(
                'projectId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'jobId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'reportStatus' => array(
              'path' => '{projectId}/jobs/{jobId}/workItems:reportStatus',
              'httpMethod' => 'POST',
              'parameters' => array(
                'projectId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'jobId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),
          )
        )
    );
  }
}


/**
 * The "v1b3" collection of methods.
 * Typical usage is:
 *  <code>
 *   $dataflowService = new Google_Service_Dataflow(...);
 *   $v1b3 = $dataflowService->v1b3;
 *  </code>
 */
class Google_Service_Dataflow_V1b3_Resource extends Google_Service_Resource
{
}

/**
 * The "projects" collection of methods.
 * Typical usage is:
 *  <code>
 *   $dataflowService = new Google_Service_Dataflow(...);
 *   $projects = $dataflowService->projects;
 *  </code>
 */
class Google_Service_Dataflow_V1b3Projects_Resource extends Google_Service_Resource
{
}

/**
 * The "jobs" collection of methods.
 * Typical usage is:
 *  <code>
 *   $dataflowService = new Google_Service_Dataflow(...);
 *   $jobs = $dataflowService->jobs;
 *  </code>
 */
class Google_Service_Dataflow_V1b3ProjectsJobs_Resource extends Google_Service_Resource
{

  /**
   * Creates a dataflow job. (jobs.create)
   *
   * @param string     $projectId
   * @param Google_Job $postBody
   * @param array      $optParams Optional parameters.
   *
   * @opt_param string view
   * @return Google_Service_Dataflow_Job
   */
  public function create($projectId, Google_Service_Dataflow_Job $postBody, $optParams = array())
  {
    $params = array('projectId' => $projectId, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('create', array($params), "Google_Service_Dataflow_Job");
  }

  /**
   * Gets the state of the specified dataflow job. (jobs.get)
   *
   * @param string $projectId
   * @param string $jobId
   * @param array  $optParams Optional parameters.
   *
   * @opt_param string view
   * @return Google_Service_Dataflow_Job
   */
  public function get($projectId, $jobId, $optParams = array())
  {
    $params = array('projectId' => $projectId, 'jobId' => $jobId);
    $params = array_merge($params, $optParams);
    return $this->call('get', array($params), "Google_Service_Dataflow_Job");
  }

  /**
   * Request the job status. (jobs.getMetrics)
   *
   * @param string $projectId
   * @param string $jobId
   * @param array  $optParams Optional parameters.
   *
   * @opt_param string startTime
   * @return Google_Service_Dataflow_JobMetrics
   */
  public function getMetrics($projectId, $jobId, $optParams = array())
  {
    $params = array('projectId' => $projectId, 'jobId' => $jobId);
    $params = array_merge($params, $optParams);
    return $this->call('getMetrics', array($params), "Google_Service_Dataflow_JobMetrics");
  }

  /**
   * List the jobs of a project (jobs.listV1b3ProjectsJobs)
   *
   * @param string $projectId
   * @param array  $optParams Optional parameters.
   *
   * @opt_param string pageToken
   * @opt_param string view
   * @opt_param int pageSize
   * @return Google_Service_Dataflow_ListJobsResponse
   */
  public function listV1b3ProjectsJobs($projectId, $optParams = array())
  {
    $params = array('projectId' => $projectId);
    $params = array_merge($params, $optParams);
    return $this->call('list', array($params), "Google_Service_Dataflow_ListJobsResponse");
  }

  /**
   * Updates the state of an existing dataflow job. This method supports patch
   * semantics. (jobs.patch)
   *
   * @param string     $projectId
   * @param string     $jobId
   * @param Google_Job $postBody
   * @param array      $optParams Optional parameters.
   *
   * @return Google_Service_Dataflow_Job
   */
  public function patch($projectId, $jobId, Google_Service_Dataflow_Job $postBody, $optParams = array())
  {
    $params = array('projectId' => $projectId, 'jobId' => $jobId, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('patch', array($params), "Google_Service_Dataflow_Job");
  }

  /**
   * Updates the state of an existing dataflow job. (jobs.update)
   *
   * @param string     $projectId
   * @param string     $jobId
   * @param Google_Job $postBody
   * @param array      $optParams Optional parameters.
   *
   * @return Google_Service_Dataflow_Job
   */
  public function update($projectId, $jobId, Google_Service_Dataflow_Job $postBody, $optParams = array())
  {
    $params = array('projectId' => $projectId, 'jobId' => $jobId, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('update', array($params), "Google_Service_Dataflow_Job");
  }
}

/**
 * The "messages" collection of methods.
 * Typical usage is:
 *  <code>
 *   $dataflowService = new Google_Service_Dataflow(...);
 *   $messages = $dataflowService->messages;
 *  </code>
 */
class Google_Service_Dataflow_V1b3ProjectsJobsMessages_Resource extends Google_Service_Resource
{

  /**
   * Request the job status. (messages.listV1b3ProjectsJobsMessages)
   *
   * @param string $projectId
   * @param string $jobId
   * @param array  $optParams Optional parameters.
   *
   * @opt_param int pageSize
   * @opt_param string pageToken
   * @opt_param string startTime
   * @opt_param string endTime
   * @opt_param string minimumImportance
   * @return Google_Service_Dataflow_ListJobMessagesResponse
   */
  public function listV1b3ProjectsJobsMessages($projectId, $jobId, $optParams = array())
  {
    $params = array('projectId' => $projectId, 'jobId' => $jobId);
    $params = array_merge($params, $optParams);
    return $this->call('list', array($params), "Google_Service_Dataflow_ListJobMessagesResponse");
  }
}
/**
 * The "workItems" collection of methods.
 * Typical usage is:
 *  <code>
 *   $dataflowService = new Google_Service_Dataflow(...);
 *   $workItems = $dataflowService->workItems;
 *  </code>
 */
class Google_Service_Dataflow_V1b3ProjectsJobsWorkItems_Resource extends Google_Service_Resource
{

  /**
   * Leases a dataflow WorkItem to run. (workItems.lease)
   *
   * @param string                      $projectId
   * @param string                      $jobId
   * @param Google_LeaseWorkItemRequest $postBody
   * @param array                       $optParams Optional parameters.
   *
   * @return Google_Service_Dataflow_LeaseWorkItemResponse
   */
  public function lease($projectId, $jobId, Google_Service_Dataflow_LeaseWorkItemRequest $postBody, $optParams = array())
  {
    $params = array('projectId' => $projectId, 'jobId' => $jobId, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('lease', array($params), "Google_Service_Dataflow_LeaseWorkItemResponse");
  }

  /**
   * Reports the status of dataflow WorkItems leased by a worker.
   * (workItems.reportStatus)
   *
   * @param string $projectId
   * @param string $jobId
   * @param Google_ReportWorkItemStatusRequest $postBody
   * @param array $optParams Optional parameters.
   *
   * @return Google_Service_Dataflow_ReportWorkItemStatusResponse
   */
  public function reportStatus($projectId, $jobId, Google_Service_Dataflow_ReportWorkItemStatusRequest $postBody, $optParams = array())
  {
    $params = array('projectId' => $projectId, 'jobId' => $jobId, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('reportStatus', array($params), "Google_Service_Dataflow_ReportWorkItemStatusResponse");
  }
}




class Google_Service_Dataflow_ApproximateProgress extends Google_Model
{
  public $percentComplete;
    public $remainingTime;
    protected $internal_gapi_mappings = array();
  protected $positionType = 'Google_Service_Dataflow_Position';
  protected $positionDataType = '';

  public function getPercentComplete()
  {
    return $this->percentComplete;
  }

    public function setPercentComplete($percentComplete)
    {
        $this->percentComplete = $percentComplete;
    }

  public function setPosition(Google_Service_Dataflow_Position $position)
  {
    $this->position = $position;
  }
  public function getPosition()
  {
    return $this->position;
  }

  public function getRemainingTime()
  {
    return $this->remainingTime;
  }

    public function setRemainingTime($remainingTime)
    {
        $this->remainingTime = $remainingTime;
    }
}

class Google_Service_Dataflow_AutoscalingSettings extends Google_Model
{
  public $algorithm;
  public $maxNumWorkers;
    protected $internal_gapi_mappings = array();

  public function getAlgorithm()
  {
    return $this->algorithm;
  }

    public function setAlgorithm($algorithm)
  {
      $this->algorithm = $algorithm;
  }

  public function getMaxNumWorkers()
  {
    return $this->maxNumWorkers;
  }

    public function setMaxNumWorkers($maxNumWorkers)
    {
        $this->maxNumWorkers = $maxNumWorkers;
    }
}

class Google_Service_Dataflow_ComputationTopology extends Google_Collection
{
    public $computationId;
  protected $collection_key = 'outputs';
  protected $internal_gapi_mappings = array(
  );
  protected $inputsType = 'Google_Service_Dataflow_StreamLocation';
  protected $inputsDataType = 'array';
  protected $keyRangesType = 'Google_Service_Dataflow_KeyRangeLocation';
  protected $keyRangesDataType = 'array';
  protected $outputsType = 'Google_Service_Dataflow_StreamLocation';
  protected $outputsDataType = 'array';

  public function getComputationId()
  {
    return $this->computationId;
  }

    public function setComputationId($computationId)
    {
        $this->computationId = $computationId;
    }

  public function setInputs($inputs)
  {
    $this->inputs = $inputs;
  }
  public function getInputs()
  {
    return $this->inputs;
  }
  public function setKeyRanges($keyRanges)
  {
    $this->keyRanges = $keyRanges;
  }
  public function getKeyRanges()
  {
    return $this->keyRanges;
  }
  public function setOutputs($outputs)
  {
    $this->outputs = $outputs;
  }
  public function getOutputs()
  {
    return $this->outputs;
  }
}

class Google_Service_Dataflow_DataDiskAssignment extends Google_Collection
{
  public $dataDisks;
  public $vmInstance;
    protected $collection_key = 'dataDisks';
    protected $internal_gapi_mappings = array();

  public function getDataDisks()
  {
    return $this->dataDisks;
  }

    public function setDataDisks($dataDisks)
  {
      $this->dataDisks = $dataDisks;
  }

  public function getVmInstance()
  {
    return $this->vmInstance;
  }

    public function setVmInstance($vmInstance)
    {
        $this->vmInstance = $vmInstance;
    }
}

class Google_Service_Dataflow_Disk extends Google_Model
{
  public $diskType;
  public $mountPoint;
  public $sizeGb;
    protected $internal_gapi_mappings = array();

  public function getDiskType()
  {
    return $this->diskType;
  }

    public function setDiskType($diskType)
  {
      $this->diskType = $diskType;
  }

  public function getMountPoint()
  {
    return $this->mountPoint;
  }

    public function setMountPoint($mountPoint)
  {
      $this->mountPoint = $mountPoint;
  }

  public function getSizeGb()
  {
    return $this->sizeGb;
  }

    public function setSizeGb($sizeGb)
    {
        $this->sizeGb = $sizeGb;
    }
}

class Google_Service_Dataflow_Environment extends Google_Collection
{
  public $clusterManagerApiService;
  public $dataset;
  public $experiments;
  public $tempStoragePrefix;
  public $userAgent;
  public $version;
    protected $collection_key = 'workerPools';
    protected $internal_gapi_mappings = array();
  protected $workerPoolsType = 'Google_Service_Dataflow_WorkerPool';
  protected $workerPoolsDataType = 'array';

  public function getClusterManagerApiService()
  {
    return $this->clusterManagerApiService;
  }

    public function setClusterManagerApiService($clusterManagerApiService)
  {
      $this->clusterManagerApiService = $clusterManagerApiService;
  }

  public function getDataset()
  {
    return $this->dataset;
  }

    public function setDataset($dataset)
  {
      $this->dataset = $dataset;
  }

  public function getExperiments()
  {
    return $this->experiments;
  }

    public function setExperiments($experiments)
  {
      $this->experiments = $experiments;
  }

  public function getTempStoragePrefix()
  {
    return $this->tempStoragePrefix;
  }

    public function setTempStoragePrefix($tempStoragePrefix)
  {
      $this->tempStoragePrefix = $tempStoragePrefix;
  }

  public function getUserAgent()
  {
    return $this->userAgent;
  }

    public function setUserAgent($userAgent)
  {
      $this->userAgent = $userAgent;
  }

  public function getVersion()
  {
    return $this->version;
  }

    public function setVersion($version)
    {
        $this->version = $version;
    }

  public function setWorkerPools($workerPools)
  {
    $this->workerPools = $workerPools;
  }
  public function getWorkerPools()
  {
    return $this->workerPools;
  }
}

class Google_Service_Dataflow_EnvironmentUserAgent extends Google_Model
{
}

class Google_Service_Dataflow_EnvironmentVersion extends Google_Model
{
}

class Google_Service_Dataflow_FlattenInstruction extends Google_Collection
{
  protected $collection_key = 'inputs';
  protected $internal_gapi_mappings = array(
  );
  protected $inputsType = 'Google_Service_Dataflow_InstructionInput';
  protected $inputsDataType = 'array';


  public function setInputs($inputs)
  {
    $this->inputs = $inputs;
  }
  public function getInputs()
  {
    return $this->inputs;
  }
}

class Google_Service_Dataflow_InstructionInput extends Google_Model
{
  public $outputNum;
  public $producerInstructionIndex;
    protected $internal_gapi_mappings = array();

  public function getOutputNum()
  {
    return $this->outputNum;
  }

    public function setOutputNum($outputNum)
  {
      $this->outputNum = $outputNum;
  }

  public function getProducerInstructionIndex()
  {
    return $this->producerInstructionIndex;
  }

    public function setProducerInstructionIndex($producerInstructionIndex)
    {
        $this->producerInstructionIndex = $producerInstructionIndex;
    }
}

class Google_Service_Dataflow_InstructionOutput extends Google_Model
{
  public $codec;
  public $name;
    protected $internal_gapi_mappings = array();

  public function getCodec()
  {
    return $this->codec;
  }

    public function setCodec($codec)
  {
      $this->codec = $codec;
  }

  public function getName()
  {
    return $this->name;
  }

    public function setName($name)
    {
        $this->name = $name;
    }
}

class Google_Service_Dataflow_InstructionOutputCodec extends Google_Model
{
}

class Google_Service_Dataflow_Job extends Google_Collection
{
  public $createTime;
  public $currentState;
  public $currentStateTime;
  public $id;
  public $name;
  public $projectId;
  public $requestedState;
    public $type;
    protected $collection_key = 'steps';
    protected $internal_gapi_mappings = array();
    protected $environmentType = 'Google_Service_Dataflow_Environment';
    protected $environmentDataType = '';
    protected $executionInfoType = 'Google_Service_Dataflow_JobExecutionInfo';
    protected $executionInfoDataType = '';
  protected $stepsType = 'Google_Service_Dataflow_Step';
  protected $stepsDataType = 'array';

  public function getCreateTime()
  {
    return $this->createTime;
  }

    public function setCreateTime($createTime)
  {
      $this->createTime = $createTime;
  }

  public function getCurrentState()
  {
    return $this->currentState;
  }

    public function setCurrentState($currentState)
  {
      $this->currentState = $currentState;
  }

  public function getCurrentStateTime()
  {
    return $this->currentStateTime;
  }

    public function setCurrentStateTime($currentStateTime)
    {
        $this->currentStateTime = $currentStateTime;
    }

  public function setEnvironment(Google_Service_Dataflow_Environment $environment)
  {
    $this->environment = $environment;
  }
  public function getEnvironment()
  {
    return $this->environment;
  }
  public function setExecutionInfo(Google_Service_Dataflow_JobExecutionInfo $executionInfo)
  {
    $this->executionInfo = $executionInfo;
  }
  public function getExecutionInfo()
  {
    return $this->executionInfo;
  }

  public function getId()
  {
    return $this->id;
  }

    public function setId($id)
  {
      $this->id = $id;
  }

  public function getName()
  {
    return $this->name;
  }

    public function setName($name)
  {
      $this->name = $name;
  }

  public function getProjectId()
  {
    return $this->projectId;
  }

    public function setProjectId($projectId)
  {
      $this->projectId = $projectId;
  }

  public function getRequestedState()
  {
    return $this->requestedState;
  }

    public function setRequestedState($requestedState)
    {
        $this->requestedState = $requestedState;
    }

  public function setSteps($steps)
  {
    $this->steps = $steps;
  }
  public function getSteps()
  {
    return $this->steps;
  }

  public function getType()
  {
    return $this->type;
  }

    public function setType($type)
    {
        $this->type = $type;
    }
}

class Google_Service_Dataflow_JobExecutionInfo extends Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $stagesType = 'Google_Service_Dataflow_JobExecutionStageInfo';
  protected $stagesDataType = 'map';


  public function setStages($stages)
  {
    $this->stages = $stages;
  }
  public function getStages()
  {
    return $this->stages;
  }
}

class Google_Service_Dataflow_JobExecutionInfoStages extends Google_Model
{
}

class Google_Service_Dataflow_JobExecutionStageInfo extends Google_Collection
{
    public $stepName;
  protected $collection_key = 'stepName';
  protected $internal_gapi_mappings = array(
  );

  public function getStepName()
  {
    return $this->stepName;
  }

    public function setStepName($stepName)
    {
        $this->stepName = $stepName;
    }
}

class Google_Service_Dataflow_JobMessage extends Google_Model
{
  public $id;
  public $messageImportance;
  public $messageText;
  public $time;
    protected $internal_gapi_mappings = array();

  public function getId()
  {
    return $this->id;
  }

    public function setId($id)
  {
      $this->id = $id;
  }

  public function getMessageImportance()
  {
    return $this->messageImportance;
  }

    public function setMessageImportance($messageImportance)
  {
      $this->messageImportance = $messageImportance;
  }

  public function getMessageText()
  {
    return $this->messageText;
  }

    public function setMessageText($messageText)
  {
      $this->messageText = $messageText;
  }

  public function getTime()
  {
    return $this->time;
  }

    public function setTime($time)
    {
        $this->time = $time;
    }
}

class Google_Service_Dataflow_JobMetrics extends Google_Collection
{
    public $metricTime;
  protected $collection_key = 'metrics';
  protected $internal_gapi_mappings = array(
  );
  protected $metricsType = 'Google_Service_Dataflow_MetricUpdate';
  protected $metricsDataType = 'array';

  public function getMetricTime()
  {
    return $this->metricTime;
  }

    public function setMetricTime($metricTime)
    {
        $this->metricTime = $metricTime;
    }

  public function setMetrics($metrics)
  {
    $this->metrics = $metrics;
  }
  public function getMetrics()
  {
    return $this->metrics;
  }
}

class Google_Service_Dataflow_KeyRangeLocation extends Google_Model
{
  public $dataDisk;
  public $deliveryEndpoint;
  public $end;
  public $persistentDirectory;
  public $start;
    protected $internal_gapi_mappings = array();

  public function getDataDisk()
  {
    return $this->dataDisk;
  }

    public function setDataDisk($dataDisk)
  {
      $this->dataDisk = $dataDisk;
  }

  public function getDeliveryEndpoint()
  {
    return $this->deliveryEndpoint;
  }

    public function setDeliveryEndpoint($deliveryEndpoint)
  {
      $this->deliveryEndpoint = $deliveryEndpoint;
  }

  public function getEnd()
  {
    return $this->end;
  }

    public function setEnd($end)
  {
      $this->end = $end;
  }

  public function getPersistentDirectory()
  {
    return $this->persistentDirectory;
  }

    public function setPersistentDirectory($persistentDirectory)
  {
      $this->persistentDirectory = $persistentDirectory;
  }

  public function getStart()
  {
    return $this->start;
  }

    public function setStart($start)
    {
        $this->start = $start;
    }
}

class Google_Service_Dataflow_LeaseWorkItemRequest extends Google_Collection
{
  public $currentWorkerTime;
  public $requestedLeaseDuration;
  public $workItemTypes;
  public $workerCapabilities;
  public $workerId;
    protected $collection_key = 'workerCapabilities';
    protected $internal_gapi_mappings = array();

  public function getCurrentWorkerTime()
  {
    return $this->currentWorkerTime;
  }

    public function setCurrentWorkerTime($currentWorkerTime)
  {
      $this->currentWorkerTime = $currentWorkerTime;
  }

  public function getRequestedLeaseDuration()
  {
    return $this->requestedLeaseDuration;
  }

    public function setRequestedLeaseDuration($requestedLeaseDuration)
  {
      $this->requestedLeaseDuration = $requestedLeaseDuration;
  }

  public function getWorkItemTypes()
  {
    return $this->workItemTypes;
  }

    public function setWorkItemTypes($workItemTypes)
  {
      $this->workItemTypes = $workItemTypes;
  }

  public function getWorkerCapabilities()
  {
    return $this->workerCapabilities;
  }

    public function setWorkerCapabilities($workerCapabilities)
  {
      $this->workerCapabilities = $workerCapabilities;
  }

  public function getWorkerId()
  {
    return $this->workerId;
  }

    public function setWorkerId($workerId)
    {
        $this->workerId = $workerId;
    }
}

class Google_Service_Dataflow_LeaseWorkItemResponse extends Google_Collection
{
  protected $collection_key = 'workItems';
  protected $internal_gapi_mappings = array(
  );
  protected $workItemsType = 'Google_Service_Dataflow_WorkItem';
  protected $workItemsDataType = 'array';


  public function setWorkItems($workItems)
  {
    $this->workItems = $workItems;
  }
  public function getWorkItems()
  {
    return $this->workItems;
  }
}

class Google_Service_Dataflow_ListJobMessagesResponse extends Google_Collection
{
    public $nextPageToken;
  protected $collection_key = 'jobMessages';
  protected $internal_gapi_mappings = array(
  );
  protected $jobMessagesType = 'Google_Service_Dataflow_JobMessage';
  protected $jobMessagesDataType = 'array';

  public function setJobMessages($jobMessages)
  {
    $this->jobMessages = $jobMessages;
  }
  public function getJobMessages()
  {
    return $this->jobMessages;
  }

  public function getNextPageToken()
  {
    return $this->nextPageToken;
  }

    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
}

class Google_Service_Dataflow_ListJobsResponse extends Google_Collection
{
    public $nextPageToken;
  protected $collection_key = 'jobs';
  protected $internal_gapi_mappings = array(
  );
  protected $jobsType = 'Google_Service_Dataflow_Job';
  protected $jobsDataType = 'array';

  public function setJobs($jobs)
  {
    $this->jobs = $jobs;
  }
  public function getJobs()
  {
    return $this->jobs;
  }

  public function getNextPageToken()
  {
    return $this->nextPageToken;
  }

    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
}

class Google_Service_Dataflow_MapTask extends Google_Collection
{
    public $stageName;
    public $systemName;
  protected $collection_key = 'instructions';
  protected $internal_gapi_mappings = array(
  );
  protected $instructionsType = 'Google_Service_Dataflow_ParallelInstruction';
  protected $instructionsDataType = 'array';

  public function setInstructions($instructions)
  {
    $this->instructions = $instructions;
  }
  public function getInstructions()
  {
    return $this->instructions;
  }

  public function getStageName()
  {
    return $this->stageName;
  }

    public function setStageName($stageName)
  {
      $this->stageName = $stageName;
  }

  public function getSystemName()
  {
    return $this->systemName;
  }

    public function setSystemName($systemName)
    {
        $this->systemName = $systemName;
    }
}

class Google_Service_Dataflow_MetricStructuredName extends Google_Model
{
  public $context;
  public $name;
  public $origin;
    protected $internal_gapi_mappings = array();

  public function getContext()
  {
    return $this->context;
  }

    public function setContext($context)
  {
      $this->context = $context;
  }

  public function getName()
  {
    return $this->name;
  }

    public function setName($name)
  {
      $this->name = $name;
  }

  public function getOrigin()
  {
    return $this->origin;
  }

    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }
}

class Google_Service_Dataflow_MetricStructuredNameContext extends Google_Model
{
}

class Google_Service_Dataflow_MetricUpdate extends Google_Model
{
  public $cumulative;
  public $internal;
  public $kind;
  public $meanCount;
  public $meanSum;
  public $scalar;
  public $set;
  public $updateTime;
    protected $internal_gapi_mappings = array();
    protected $nameType = 'Google_Service_Dataflow_MetricStructuredName';
    protected $nameDataType = '';

  public function getCumulative()
  {
    return $this->cumulative;
  }

    public function setCumulative($cumulative)
  {
      $this->cumulative = $cumulative;
  }

  public function getInternal()
  {
    return $this->internal;
  }

    public function setInternal($internal)
  {
      $this->internal = $internal;
  }

  public function getKind()
  {
    return $this->kind;
  }

    public function setKind($kind)
  {
      $this->kind = $kind;
  }

  public function getMeanCount()
  {
    return $this->meanCount;
  }

    public function setMeanCount($meanCount)
  {
      $this->meanCount = $meanCount;
  }

  public function getMeanSum()
  {
    return $this->meanSum;
  }

    public function setMeanSum($meanSum)
    {
        $this->meanSum = $meanSum;
    }

  public function setName(Google_Service_Dataflow_MetricStructuredName $name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }

  public function getScalar()
  {
    return $this->scalar;
  }

    public function setScalar($scalar)
  {
      $this->scalar = $scalar;
  }

  public function getSet()
  {
    return $this->set;
  }

    public function setSet($set)
  {
      $this->set = $set;
  }

  public function getUpdateTime()
  {
    return $this->updateTime;
  }

    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    }
}

class Google_Service_Dataflow_MultiOutputInfo extends Google_Model
{
  public $tag;
    protected $internal_gapi_mappings = array();

  public function getTag()
  {
    return $this->tag;
  }

    public function setTag($tag)
    {
        $this->tag = $tag;
    }
}

class Google_Service_Dataflow_Package extends Google_Model
{
  public $location;
  public $name;
    protected $internal_gapi_mappings = array();

  public function getLocation()
  {
    return $this->location;
  }

    public function setLocation($location)
  {
      $this->location = $location;
  }

  public function getName()
  {
    return $this->name;
  }

    public function setName($name)
    {
        $this->name = $name;
    }
}

class Google_Service_Dataflow_ParDoInstruction extends Google_Collection
{
    public $numOutputs;
    public $userFn;
  protected $collection_key = 'sideInputs';
  protected $internal_gapi_mappings = array(
  );
  protected $inputType = 'Google_Service_Dataflow_InstructionInput';
  protected $inputDataType = '';
  protected $multiOutputInfosType = 'Google_Service_Dataflow_MultiOutputInfo';
  protected $multiOutputInfosDataType = 'array';
  protected $sideInputsType = 'Google_Service_Dataflow_SideInputInfo';
  protected $sideInputsDataType = 'array';

  public function setInput(Google_Service_Dataflow_InstructionInput $input)
  {
    $this->input = $input;
  }
  public function getInput()
  {
    return $this->input;
  }
  public function setMultiOutputInfos($multiOutputInfos)
  {
    $this->multiOutputInfos = $multiOutputInfos;
  }
  public function getMultiOutputInfos()
  {
    return $this->multiOutputInfos;
  }

  public function getNumOutputs()
  {
    return $this->numOutputs;
  }

    public function setNumOutputs($numOutputs)
    {
        $this->numOutputs = $numOutputs;
    }

  public function setSideInputs($sideInputs)
  {
    $this->sideInputs = $sideInputs;
  }
  public function getSideInputs()
  {
    return $this->sideInputs;
  }

  public function getUserFn()
  {
    return $this->userFn;
  }

    public function setUserFn($userFn)
    {
        $this->userFn = $userFn;
    }
}

class Google_Service_Dataflow_ParDoInstructionUserFn extends Google_Model
{
}

class Google_Service_Dataflow_ParallelInstruction extends Google_Collection
{
    public $name;
    public $systemName;
  protected $collection_key = 'outputs';
  protected $internal_gapi_mappings = array(
  );
  protected $flattenType = 'Google_Service_Dataflow_FlattenInstruction';
  protected $flattenDataType = '';
  protected $outputsType = 'Google_Service_Dataflow_InstructionOutput';
  protected $outputsDataType = 'array';
  protected $parDoType = 'Google_Service_Dataflow_ParDoInstruction';
  protected $parDoDataType = '';
  protected $partialGroupByKeyType = 'Google_Service_Dataflow_PartialGroupByKeyInstruction';
  protected $partialGroupByKeyDataType = '';
  protected $readType = 'Google_Service_Dataflow_ReadInstruction';
  protected $readDataType = '';
  protected $writeType = 'Google_Service_Dataflow_WriteInstruction';
  protected $writeDataType = '';


  public function setFlatten(Google_Service_Dataflow_FlattenInstruction $flatten)
  {
    $this->flatten = $flatten;
  }
  public function getFlatten()
  {
    return $this->flatten;
  }

  public function getName()
  {
    return $this->name;
  }

    public function setName($name)
    {
        $this->name = $name;
    }

  public function setOutputs($outputs)
  {
    $this->outputs = $outputs;
  }
  public function getOutputs()
  {
    return $this->outputs;
  }
  public function setParDo(Google_Service_Dataflow_ParDoInstruction $parDo)
  {
    $this->parDo = $parDo;
  }
  public function getParDo()
  {
    return $this->parDo;
  }
  public function setPartialGroupByKey(Google_Service_Dataflow_PartialGroupByKeyInstruction $partialGroupByKey)
  {
    $this->partialGroupByKey = $partialGroupByKey;
  }
  public function getPartialGroupByKey()
  {
    return $this->partialGroupByKey;
  }
  public function setRead(Google_Service_Dataflow_ReadInstruction $read)
  {
    $this->read = $read;
  }
  public function getRead()
  {
    return $this->read;
  }

  public function getSystemName()
  {
    return $this->systemName;
  }

    public function setSystemName($systemName)
    {
        $this->systemName = $systemName;
    }

  public function setWrite(Google_Service_Dataflow_WriteInstruction $write)
  {
    $this->write = $write;
  }
  public function getWrite()
  {
    return $this->write;
  }
}

class Google_Service_Dataflow_PartialGroupByKeyInstruction extends Google_Model
{
    public $inputElementCodec;
  protected $internal_gapi_mappings = array(
  );
  protected $inputType = 'Google_Service_Dataflow_InstructionInput';
  protected $inputDataType = '';

  public function setInput(Google_Service_Dataflow_InstructionInput $input)
  {
    $this->input = $input;
  }
  public function getInput()
  {
    return $this->input;
  }

  public function getInputElementCodec()
  {
    return $this->inputElementCodec;
  }

    public function setInputElementCodec($inputElementCodec)
    {
        $this->inputElementCodec = $inputElementCodec;
    }
}

class Google_Service_Dataflow_PartialGroupByKeyInstructionInputElementCodec extends Google_Model
{
}

class Google_Service_Dataflow_Position extends Google_Model
{
  public $byteOffset;
  public $end;
  public $key;
  public $recordIndex;
  public $shufflePosition;
    protected $internal_gapi_mappings = array();

  public function getByteOffset()
  {
    return $this->byteOffset;
  }

    public function setByteOffset($byteOffset)
  {
      $this->byteOffset = $byteOffset;
  }

  public function getEnd()
  {
    return $this->end;
  }

    public function setEnd($end)
  {
      $this->end = $end;
  }

  public function getKey()
  {
    return $this->key;
  }

    public function setKey($key)
  {
      $this->key = $key;
  }

  public function getRecordIndex()
  {
    return $this->recordIndex;
  }

    public function setRecordIndex($recordIndex)
  {
      $this->recordIndex = $recordIndex;
  }

  public function getShufflePosition()
  {
    return $this->shufflePosition;
  }

    public function setShufflePosition($shufflePosition)
    {
        $this->shufflePosition = $shufflePosition;
    }
}

class Google_Service_Dataflow_PubsubLocation extends Google_Model
{
  public $subscription;
  public $topic;
    protected $internal_gapi_mappings = array();

  public function getSubscription()
  {
    return $this->subscription;
  }

    public function setSubscription($subscription)
  {
      $this->subscription = $subscription;
  }

  public function getTopic()
  {
    return $this->topic;
  }

    public function setTopic($topic)
    {
        $this->topic = $topic;
    }
}

class Google_Service_Dataflow_ReadInstruction extends Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $sourceType = 'Google_Service_Dataflow_Source';
  protected $sourceDataType = '';


  public function setSource(Google_Service_Dataflow_Source $source)
  {
    $this->source = $source;
  }
  public function getSource()
  {
    return $this->source;
  }
}

class Google_Service_Dataflow_ReportWorkItemStatusRequest extends Google_Collection
{
    public $currentWorkerTime;
    public $workerId;
  protected $collection_key = 'workItemStatuses';
  protected $internal_gapi_mappings = array(
  );
  protected $workItemStatusesType = 'Google_Service_Dataflow_WorkItemStatus';
  protected $workItemStatusesDataType = 'array';

  public function getCurrentWorkerTime()
  {
    return $this->currentWorkerTime;
  }

    public function setCurrentWorkerTime($currentWorkerTime)
    {
        $this->currentWorkerTime = $currentWorkerTime;
    }

  public function setWorkItemStatuses($workItemStatuses)
  {
    $this->workItemStatuses = $workItemStatuses;
  }
  public function getWorkItemStatuses()
  {
    return $this->workItemStatuses;
  }

  public function getWorkerId()
  {
    return $this->workerId;
  }

    public function setWorkerId($workerId)
    {
        $this->workerId = $workerId;
    }
}

class Google_Service_Dataflow_ReportWorkItemStatusResponse extends Google_Collection
{
  protected $collection_key = 'workItemServiceStates';
  protected $internal_gapi_mappings = array(
  );
  protected $workItemServiceStatesType = 'Google_Service_Dataflow_WorkItemServiceState';
  protected $workItemServiceStatesDataType = 'array';


  public function setWorkItemServiceStates($workItemServiceStates)
  {
    $this->workItemServiceStates = $workItemServiceStates;
  }
  public function getWorkItemServiceStates()
  {
    return $this->workItemServiceStates;
  }
}

class Google_Service_Dataflow_SeqMapTask extends Google_Collection
{
    public $name;
    public $stageName;
    public $systemName;
    public $userFn;
  protected $collection_key = 'outputInfos';
  protected $internal_gapi_mappings = array(
  );
  protected $inputsType = 'Google_Service_Dataflow_SideInputInfo';
  protected $inputsDataType = 'array';
  protected $outputInfosType = 'Google_Service_Dataflow_SeqMapTaskOutputInfo';
  protected $outputInfosDataType = 'array';

  public function setInputs($inputs)
  {
    $this->inputs = $inputs;
  }
  public function getInputs()
  {
    return $this->inputs;
  }

  public function getName()
  {
    return $this->name;
  }

    public function setName($name)
    {
        $this->name = $name;
    }

  public function setOutputInfos($outputInfos)
  {
    $this->outputInfos = $outputInfos;
  }
  public function getOutputInfos()
  {
    return $this->outputInfos;
  }

  public function getStageName()
  {
    return $this->stageName;
  }

    public function setStageName($stageName)
  {
      $this->stageName = $stageName;
  }

  public function getSystemName()
  {
    return $this->systemName;
  }

    public function setSystemName($systemName)
  {
      $this->systemName = $systemName;
  }

  public function getUserFn()
  {
    return $this->userFn;
  }

    public function setUserFn($userFn)
    {
        $this->userFn = $userFn;
    }
}

class Google_Service_Dataflow_SeqMapTaskOutputInfo extends Google_Model
{
    public $tag;
  protected $internal_gapi_mappings = array(
  );
  protected $sinkType = 'Google_Service_Dataflow_Sink';
  protected $sinkDataType = '';

  public function setSink(Google_Service_Dataflow_Sink $sink)
  {
    $this->sink = $sink;
  }
  public function getSink()
  {
    return $this->sink;
  }

  public function getTag()
  {
    return $this->tag;
  }

    public function setTag($tag)
    {
        $this->tag = $tag;
    }
}

class Google_Service_Dataflow_SeqMapTaskUserFn extends Google_Model
{
}

class Google_Service_Dataflow_ShellTask extends Google_Model
{
  public $command;
  public $exitCode;
    protected $internal_gapi_mappings = array();

  public function getCommand()
  {
    return $this->command;
  }

    public function setCommand($command)
  {
      $this->command = $command;
  }

  public function getExitCode()
  {
    return $this->exitCode;
  }

    public function setExitCode($exitCode)
    {
        $this->exitCode = $exitCode;
    }
}

class Google_Service_Dataflow_SideInputInfo extends Google_Collection
{
    public $kind;
    public $tag;
  protected $collection_key = 'sources';
  protected $internal_gapi_mappings = array(
  );
  protected $sourcesType = 'Google_Service_Dataflow_Source';
  protected $sourcesDataType = 'array';

  public function getKind()
  {
    return $this->kind;
  }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

  public function setSources($sources)
  {
    $this->sources = $sources;
  }
  public function getSources()
  {
    return $this->sources;
  }

  public function getTag()
  {
    return $this->tag;
  }

    public function setTag($tag)
    {
        $this->tag = $tag;
    }
}

class Google_Service_Dataflow_SideInputInfoKind extends Google_Model
{
}

class Google_Service_Dataflow_Sink extends Google_Model
{
  public $codec;
  public $spec;
    protected $internal_gapi_mappings = array();

  public function getCodec()
  {
    return $this->codec;
  }

    public function setCodec($codec)
  {
      $this->codec = $codec;
  }

  public function getSpec()
  {
    return $this->spec;
  }

    public function setSpec($spec)
    {
        $this->spec = $spec;
    }
}

class Google_Service_Dataflow_SinkCodec extends Google_Model
{
}

class Google_Service_Dataflow_SinkSpec extends Google_Model
{
}

class Google_Service_Dataflow_Source extends Google_Collection
{
  public $baseSpecs;
  public $codec;
  public $doesNotNeedSplitting;
    public $spec;
    protected $collection_key = 'baseSpecs';
    protected $internal_gapi_mappings = array();
  protected $metadataType = 'Google_Service_Dataflow_SourceMetadata';
  protected $metadataDataType = '';

  public function getBaseSpecs()
  {
    return $this->baseSpecs;
  }

    public function setBaseSpecs($baseSpecs)
  {
      $this->baseSpecs = $baseSpecs;
  }

  public function getCodec()
  {
    return $this->codec;
  }

    public function setCodec($codec)
  {
      $this->codec = $codec;
  }

  public function getDoesNotNeedSplitting()
  {
    return $this->doesNotNeedSplitting;
  }

    public function setDoesNotNeedSplitting($doesNotNeedSplitting)
    {
        $this->doesNotNeedSplitting = $doesNotNeedSplitting;
    }

  public function setMetadata(Google_Service_Dataflow_SourceMetadata $metadata)
  {
    $this->metadata = $metadata;
  }
  public function getMetadata()
  {
    return $this->metadata;
  }

  public function getSpec()
  {
    return $this->spec;
  }

    public function setSpec($spec)
    {
        $this->spec = $spec;
    }
}

class Google_Service_Dataflow_SourceBaseSpecs extends Google_Model
{
}

class Google_Service_Dataflow_SourceCodec extends Google_Model
{
}

class Google_Service_Dataflow_SourceGetMetadataRequest extends Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $sourceType = 'Google_Service_Dataflow_Source';
  protected $sourceDataType = '';


  public function setSource(Google_Service_Dataflow_Source $source)
  {
    $this->source = $source;
  }
  public function getSource()
  {
    return $this->source;
  }
}

class Google_Service_Dataflow_SourceGetMetadataResponse extends Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $metadataType = 'Google_Service_Dataflow_SourceMetadata';
  protected $metadataDataType = '';


  public function setMetadata(Google_Service_Dataflow_SourceMetadata $metadata)
  {
    $this->metadata = $metadata;
  }
  public function getMetadata()
  {
    return $this->metadata;
  }
}

class Google_Service_Dataflow_SourceMetadata extends Google_Model
{
  public $estimatedSizeBytes;
  public $infinite;
  public $producesSortedKeys;
    protected $internal_gapi_mappings = array();

  public function getEstimatedSizeBytes()
  {
    return $this->estimatedSizeBytes;
  }

    public function setEstimatedSizeBytes($estimatedSizeBytes)
  {
      $this->estimatedSizeBytes = $estimatedSizeBytes;
  }

  public function getInfinite()
  {
    return $this->infinite;
  }

    public function setInfinite($infinite)
  {
      $this->infinite = $infinite;
  }

  public function getProducesSortedKeys()
  {
    return $this->producesSortedKeys;
  }

    public function setProducesSortedKeys($producesSortedKeys)
    {
        $this->producesSortedKeys = $producesSortedKeys;
    }
}

class Google_Service_Dataflow_SourceOperationRequest extends Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $getMetadataType = 'Google_Service_Dataflow_SourceGetMetadataRequest';
  protected $getMetadataDataType = '';
  protected $splitType = 'Google_Service_Dataflow_SourceSplitRequest';
  protected $splitDataType = '';


  public function setGetMetadata(Google_Service_Dataflow_SourceGetMetadataRequest $getMetadata)
  {
    $this->getMetadata = $getMetadata;
  }
  public function getGetMetadata()
  {
    return $this->getMetadata;
  }
  public function setSplit(Google_Service_Dataflow_SourceSplitRequest $split)
  {
    $this->split = $split;
  }
  public function getSplit()
  {
    return $this->split;
  }
}

class Google_Service_Dataflow_SourceOperationResponse extends Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $getMetadataType = 'Google_Service_Dataflow_SourceGetMetadataResponse';
  protected $getMetadataDataType = '';
  protected $splitType = 'Google_Service_Dataflow_SourceSplitResponse';
  protected $splitDataType = '';


  public function setGetMetadata(Google_Service_Dataflow_SourceGetMetadataResponse $getMetadata)
  {
    $this->getMetadata = $getMetadata;
  }
  public function getGetMetadata()
  {
    return $this->getMetadata;
  }
  public function setSplit(Google_Service_Dataflow_SourceSplitResponse $split)
  {
    $this->split = $split;
  }
  public function getSplit()
  {
    return $this->split;
  }
}

class Google_Service_Dataflow_SourceSpec extends Google_Model
{
}

class Google_Service_Dataflow_SourceSplitOptions extends Google_Model
{
  public $desiredShardSizeBytes;
    protected $internal_gapi_mappings = array();

  public function getDesiredShardSizeBytes()
  {
    return $this->desiredShardSizeBytes;
  }

    public function setDesiredShardSizeBytes($desiredShardSizeBytes)
    {
        $this->desiredShardSizeBytes = $desiredShardSizeBytes;
    }
}

class Google_Service_Dataflow_SourceSplitRequest extends Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $optionsType = 'Google_Service_Dataflow_SourceSplitOptions';
  protected $optionsDataType = '';
  protected $sourceType = 'Google_Service_Dataflow_Source';
  protected $sourceDataType = '';


  public function setOptions(Google_Service_Dataflow_SourceSplitOptions $options)
  {
    $this->options = $options;
  }
  public function getOptions()
  {
    return $this->options;
  }
  public function setSource(Google_Service_Dataflow_Source $source)
  {
    $this->source = $source;
  }
  public function getSource()
  {
    return $this->source;
  }
}

class Google_Service_Dataflow_SourceSplitResponse extends Google_Collection
{
    public $outcome;
  protected $collection_key = 'shards';
  protected $internal_gapi_mappings = array(
  );
  protected $shardsType = 'Google_Service_Dataflow_SourceSplitShard';
  protected $shardsDataType = 'array';

  public function getOutcome()
  {
    return $this->outcome;
  }

    public function setOutcome($outcome)
    {
        $this->outcome = $outcome;
    }

  public function setShards($shards)
  {
    $this->shards = $shards;
  }
  public function getShards()
  {
    return $this->shards;
  }
}

class Google_Service_Dataflow_SourceSplitShard extends Google_Model
{
  public $derivationMode;
    protected $internal_gapi_mappings = array();
  protected $sourceType = 'Google_Service_Dataflow_Source';
  protected $sourceDataType = '';

  public function getDerivationMode()
  {
    return $this->derivationMode;
  }

    public function setDerivationMode($derivationMode)
    {
        $this->derivationMode = $derivationMode;
    }

  public function setSource(Google_Service_Dataflow_Source $source)
  {
    $this->source = $source;
  }
  public function getSource()
  {
    return $this->source;
  }
}

class Google_Service_Dataflow_Status extends Google_Collection
{
  public $code;
  public $details;
  public $message;
    protected $collection_key = 'details';
    protected $internal_gapi_mappings = array();

  public function getCode()
  {
    return $this->code;
  }

    public function setCode($code)
  {
      $this->code = $code;
  }

  public function getDetails()
  {
    return $this->details;
  }

    public function setDetails($details)
  {
      $this->details = $details;
  }

  public function getMessage()
  {
    return $this->message;
  }

    public function setMessage($message)
    {
        $this->message = $message;
    }
}

class Google_Service_Dataflow_StatusDetails extends Google_Model
{
}

class Google_Service_Dataflow_Step extends Google_Model
{
  public $kind;
  public $name;
  public $properties;
    protected $internal_gapi_mappings = array();

  public function getKind()
  {
    return $this->kind;
  }

    public function setKind($kind)
  {
      $this->kind = $kind;
  }

  public function getName()
  {
    return $this->name;
  }

    public function setName($name)
  {
      $this->name = $name;
  }

  public function getProperties()
  {
    return $this->properties;
  }

    public function setProperties($properties)
    {
        $this->properties = $properties;
    }
}

class Google_Service_Dataflow_StepProperties extends Google_Model
{
}

class Google_Service_Dataflow_StreamLocation extends Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $pubsubLocationType = 'Google_Service_Dataflow_PubsubLocation';
  protected $pubsubLocationDataType = '';
  protected $streamingStageLocationType = 'Google_Service_Dataflow_StreamingStageLocation';
  protected $streamingStageLocationDataType = '';


  public function setPubsubLocation(Google_Service_Dataflow_PubsubLocation $pubsubLocation)
  {
    $this->pubsubLocation = $pubsubLocation;
  }
  public function getPubsubLocation()
  {
    return $this->pubsubLocation;
  }
  public function setStreamingStageLocation(Google_Service_Dataflow_StreamingStageLocation $streamingStageLocation)
  {
    $this->streamingStageLocation = $streamingStageLocation;
  }
  public function getStreamingStageLocation()
  {
    return $this->streamingStageLocation;
  }
}

class Google_Service_Dataflow_StreamingSetupTask extends Google_Model
{
  public $receiveWorkPort;
    public $workerHarnessPort;
    protected $internal_gapi_mappings = array();
  protected $streamingComputationTopologyType = 'Google_Service_Dataflow_TopologyConfig';
  protected $streamingComputationTopologyDataType = '';

  public function getReceiveWorkPort()
  {
    return $this->receiveWorkPort;
  }

    public function setReceiveWorkPort($receiveWorkPort)
    {
        $this->receiveWorkPort = $receiveWorkPort;
    }

  public function setStreamingComputationTopology(Google_Service_Dataflow_TopologyConfig $streamingComputationTopology)
  {
    $this->streamingComputationTopology = $streamingComputationTopology;
  }
  public function getStreamingComputationTopology()
  {
    return $this->streamingComputationTopology;
  }

  public function getWorkerHarnessPort()
  {
    return $this->workerHarnessPort;
  }

    public function setWorkerHarnessPort($workerHarnessPort)
    {
        $this->workerHarnessPort = $workerHarnessPort;
    }
}

class Google_Service_Dataflow_StreamingStageLocation extends Google_Model
{
  public $streamId;
    protected $internal_gapi_mappings = array();

  public function getStreamId()
  {
    return $this->streamId;
  }

    public function setStreamId($streamId)
    {
        $this->streamId = $streamId;
    }
}

class Google_Service_Dataflow_TaskRunnerSettings extends Google_Collection
{
  public $alsologtostderr;
  public $baseTaskDir;
  public $baseUrl;
  public $commandlinesFileName;
  public $continueOnException;
  public $dataflowApiVersion;
  public $harnessCommand;
  public $languageHint;
  public $logDir;
  public $logToSerialconsole;
  public $logUploadLocation;
  public $oauthScopes;
  public $taskGroup;
  public $taskUser;
  public $tempStoragePrefix;
  public $vmId;
  public $workflowFileName;
    protected $collection_key = 'oauthScopes';
    protected $internal_gapi_mappings = array();
    protected $parallelWorkerSettingsType = 'Google_Service_Dataflow_WorkerSettings';
    protected $parallelWorkerSettingsDataType = '';

  public function getAlsologtostderr()
  {
    return $this->alsologtostderr;
  }

    public function setAlsologtostderr($alsologtostderr)
  {
      $this->alsologtostderr = $alsologtostderr;
  }

  public function getBaseTaskDir()
  {
    return $this->baseTaskDir;
  }

    public function setBaseTaskDir($baseTaskDir)
  {
      $this->baseTaskDir = $baseTaskDir;
  }

  public function getBaseUrl()
  {
    return $this->baseUrl;
  }

    public function setBaseUrl($baseUrl)
  {
      $this->baseUrl = $baseUrl;
  }

  public function getCommandlinesFileName()
  {
    return $this->commandlinesFileName;
  }

    public function setCommandlinesFileName($commandlinesFileName)
  {
      $this->commandlinesFileName = $commandlinesFileName;
  }

  public function getContinueOnException()
  {
    return $this->continueOnException;
  }

    public function setContinueOnException($continueOnException)
  {
      $this->continueOnException = $continueOnException;
  }

    public function getDataflowApiVersion()
  {
    return $this->dataflowApiVersion;
  }

    public function setDataflowApiVersion($dataflowApiVersion)
  {
      $this->dataflowApiVersion = $dataflowApiVersion;
  }

    public function getHarnessCommand()
  {
    return $this->harnessCommand;
  }

    public function setHarnessCommand($harnessCommand)
  {
      $this->harnessCommand = $harnessCommand;
  }

    public function getLanguageHint()
  {
    return $this->languageHint;
  }

    public function setLanguageHint($languageHint)
  {
      $this->languageHint = $languageHint;
  }

    public function getLogDir()
  {
    return $this->logDir;
  }

    public function setLogDir($logDir)
  {
      $this->logDir = $logDir;
  }

    public function getLogToSerialconsole()
  {
    return $this->logToSerialconsole;
  }

    public function setLogToSerialconsole($logToSerialconsole)
  {
      $this->logToSerialconsole = $logToSerialconsole;
  }

    public function getLogUploadLocation()
  {
    return $this->logUploadLocation;
  }

    public function setLogUploadLocation($logUploadLocation)
  {
      $this->logUploadLocation = $logUploadLocation;
  }

    public function getOauthScopes()
  {
    return $this->oauthScopes;
  }

    public function setOauthScopes($oauthScopes)
    {
        $this->oauthScopes = $oauthScopes;
    }

  public function setParallelWorkerSettings(Google_Service_Dataflow_WorkerSettings $parallelWorkerSettings)
  {
    $this->parallelWorkerSettings = $parallelWorkerSettings;
  }
  public function getParallelWorkerSettings()
  {
    return $this->parallelWorkerSettings;
  }

    public function getTaskGroup()
  {
    return $this->taskGroup;
  }

    public function setTaskGroup($taskGroup)
  {
      $this->taskGroup = $taskGroup;
  }

    public function getTaskUser()
  {
    return $this->taskUser;
  }

    public function setTaskUser($taskUser)
  {
      $this->taskUser = $taskUser;
  }

    public function getTempStoragePrefix()
  {
    return $this->tempStoragePrefix;
  }

    public function setTempStoragePrefix($tempStoragePrefix)
  {
      $this->tempStoragePrefix = $tempStoragePrefix;
  }

    public function getVmId()
  {
    return $this->vmId;
  }

    public function setVmId($vmId)
  {
      $this->vmId = $vmId;
  }

    public function getWorkflowFileName()
  {
    return $this->workflowFileName;
  }

    public function setWorkflowFileName($workflowFileName)
    {
        $this->workflowFileName = $workflowFileName;
    }
}

class Google_Service_Dataflow_TopologyConfig extends Google_Collection
{
  protected $collection_key = 'dataDiskAssignments';
  protected $internal_gapi_mappings = array(
  );
  protected $computationsType = 'Google_Service_Dataflow_ComputationTopology';
  protected $computationsDataType = 'array';
  protected $dataDiskAssignmentsType = 'Google_Service_Dataflow_DataDiskAssignment';
  protected $dataDiskAssignmentsDataType = 'array';


  public function setComputations($computations)
  {
    $this->computations = $computations;
  }
  public function getComputations()
  {
    return $this->computations;
  }
  public function setDataDiskAssignments($dataDiskAssignments)
  {
    $this->dataDiskAssignments = $dataDiskAssignments;
  }
  public function getDataDiskAssignments()
  {
    return $this->dataDiskAssignments;
  }
}

class Google_Service_Dataflow_WorkItem extends Google_Collection
{
  public $configuration;
  public $id;
  public $jobId;
  public $leaseExpireTime;
    public $projectId;
    public $reportStatusInterval;
    protected $collection_key = 'packages';
    protected $internal_gapi_mappings = array();
  protected $mapTaskType = 'Google_Service_Dataflow_MapTask';
  protected $mapTaskDataType = '';
  protected $packagesType = 'Google_Service_Dataflow_Package';
  protected $packagesDataType = 'array';
  protected $seqMapTaskType = 'Google_Service_Dataflow_SeqMapTask';
  protected $seqMapTaskDataType = '';
  protected $shellTaskType = 'Google_Service_Dataflow_ShellTask';
  protected $shellTaskDataType = '';
  protected $sourceOperationTaskType = 'Google_Service_Dataflow_SourceOperationRequest';
  protected $sourceOperationTaskDataType = '';
  protected $streamingSetupTaskType = 'Google_Service_Dataflow_StreamingSetupTask';
  protected $streamingSetupTaskDataType = '';

  public function getConfiguration()
  {
    return $this->configuration;
  }

    public function setConfiguration($configuration)
  {
      $this->configuration = $configuration;
  }

    public function getId()
  {
    return $this->id;
  }

    public function setId($id)
  {
      $this->id = $id;
  }

    public function getJobId()
  {
    return $this->jobId;
  }

    public function setJobId($jobId)
  {
      $this->jobId = $jobId;
  }

    public function getLeaseExpireTime()
  {
    return $this->leaseExpireTime;
  }

    public function setLeaseExpireTime($leaseExpireTime)
    {
        $this->leaseExpireTime = $leaseExpireTime;
    }

  public function setMapTask(Google_Service_Dataflow_MapTask $mapTask)
  {
    $this->mapTask = $mapTask;
  }
  public function getMapTask()
  {
    return $this->mapTask;
  }
  public function setPackages($packages)
  {
    $this->packages = $packages;
  }
  public function getPackages()
  {
    return $this->packages;
  }

    public function getProjectId()
  {
    return $this->projectId;
  }

    public function setProjectId($projectId)
  {
      $this->projectId = $projectId;
  }

    public function getReportStatusInterval()
  {
    return $this->reportStatusInterval;
  }

    public function setReportStatusInterval($reportStatusInterval)
    {
        $this->reportStatusInterval = $reportStatusInterval;
    }

  public function setSeqMapTask(Google_Service_Dataflow_SeqMapTask $seqMapTask)
  {
    $this->seqMapTask = $seqMapTask;
  }
  public function getSeqMapTask()
  {
    return $this->seqMapTask;
  }
  public function setShellTask(Google_Service_Dataflow_ShellTask $shellTask)
  {
    $this->shellTask = $shellTask;
  }
  public function getShellTask()
  {
    return $this->shellTask;
  }
  public function setSourceOperationTask(Google_Service_Dataflow_SourceOperationRequest $sourceOperationTask)
  {
    $this->sourceOperationTask = $sourceOperationTask;
  }
  public function getSourceOperationTask()
  {
    return $this->sourceOperationTask;
  }
  public function setStreamingSetupTask(Google_Service_Dataflow_StreamingSetupTask $streamingSetupTask)
  {
    $this->streamingSetupTask = $streamingSetupTask;
  }
  public function getStreamingSetupTask()
  {
    return $this->streamingSetupTask;
  }
}

class Google_Service_Dataflow_WorkItemServiceState extends Google_Model
{
  public $harnessData;
  public $leaseExpireTime;
  public $reportStatusInterval;
    protected $internal_gapi_mappings = array();
  protected $suggestedStopPointType = 'Google_Service_Dataflow_ApproximateProgress';
  protected $suggestedStopPointDataType = '';
  protected $suggestedStopPositionType = 'Google_Service_Dataflow_Position';
  protected $suggestedStopPositionDataType = '';

  public function getHarnessData()
  {
    return $this->harnessData;
  }

    public function setHarnessData($harnessData)
  {
      $this->harnessData = $harnessData;
  }

    public function getLeaseExpireTime()
  {
    return $this->leaseExpireTime;
  }

    public function setLeaseExpireTime($leaseExpireTime)
  {
      $this->leaseExpireTime = $leaseExpireTime;
  }

    public function getReportStatusInterval()
  {
    return $this->reportStatusInterval;
  }

    public function setReportStatusInterval($reportStatusInterval)
    {
        $this->reportStatusInterval = $reportStatusInterval;
    }

  public function setSuggestedStopPoint(Google_Service_Dataflow_ApproximateProgress $suggestedStopPoint)
  {
    $this->suggestedStopPoint = $suggestedStopPoint;
  }
  public function getSuggestedStopPoint()
  {
    return $this->suggestedStopPoint;
  }
  public function setSuggestedStopPosition(Google_Service_Dataflow_Position $suggestedStopPosition)
  {
    $this->suggestedStopPosition = $suggestedStopPosition;
  }
  public function getSuggestedStopPosition()
  {
    return $this->suggestedStopPosition;
  }
}

class Google_Service_Dataflow_WorkItemServiceStateHarnessData extends Google_Model
{
}

class Google_Service_Dataflow_WorkItemStatus extends Google_Collection
{
    public $completed;
    public $reportIndex;
    public $requestedLeaseDuration;
    public $workItemId;
  protected $collection_key = 'metricUpdates';
  protected $internal_gapi_mappings = array(
  );
  protected $errorsType = 'Google_Service_Dataflow_Status';
  protected $errorsDataType = 'array';
  protected $metricUpdatesType = 'Google_Service_Dataflow_MetricUpdate';
  protected $metricUpdatesDataType = 'array';
  protected $progressType = 'Google_Service_Dataflow_ApproximateProgress';
  protected $progressDataType = '';
  protected $sourceOperationResponseType = 'Google_Service_Dataflow_SourceOperationResponse';
  protected $sourceOperationResponseDataType = '';
  protected $stopPositionType = 'Google_Service_Dataflow_Position';
  protected $stopPositionDataType = '';

  public function getCompleted()
  {
    return $this->completed;
  }

    public function setCompleted($completed)
    {
        $this->completed = $completed;
    }

  public function setErrors($errors)
  {
    $this->errors = $errors;
  }
  public function getErrors()
  {
    return $this->errors;
  }
  public function setMetricUpdates($metricUpdates)
  {
    $this->metricUpdates = $metricUpdates;
  }
  public function getMetricUpdates()
  {
    return $this->metricUpdates;
  }
  public function setProgress(Google_Service_Dataflow_ApproximateProgress $progress)
  {
    $this->progress = $progress;
  }
  public function getProgress()
  {
    return $this->progress;
  }

    public function getReportIndex()
  {
    return $this->reportIndex;
  }

    public function setReportIndex($reportIndex)
  {
      $this->reportIndex = $reportIndex;
  }

    public function getRequestedLeaseDuration()
  {
    return $this->requestedLeaseDuration;
  }

    public function setRequestedLeaseDuration($requestedLeaseDuration)
    {
        $this->requestedLeaseDuration = $requestedLeaseDuration;
    }

  public function setSourceOperationResponse(Google_Service_Dataflow_SourceOperationResponse $sourceOperationResponse)
  {
    $this->sourceOperationResponse = $sourceOperationResponse;
  }
  public function getSourceOperationResponse()
  {
    return $this->sourceOperationResponse;
  }
  public function setStopPosition(Google_Service_Dataflow_Position $stopPosition)
  {
    $this->stopPosition = $stopPosition;
  }
  public function getStopPosition()
  {
    return $this->stopPosition;
  }

    public function getWorkItemId()
  {
    return $this->workItemId;
  }

    public function setWorkItemId($workItemId)
    {
        $this->workItemId = $workItemId;
    }
}

class Google_Service_Dataflow_WorkerPool extends Google_Collection
{
  public $defaultPackageSet;
  public $diskSizeGb;
  public $diskSourceImage;
  public $kind;
  public $machineType;
  public $metadata;
  public $numWorkers;
  public $onHostMaintenance;
    public $teardownPolicy;
    public $zone;
    protected $collection_key = 'packages';
    protected $internal_gapi_mappings = array();
    protected $autoscalingSettingsType = 'Google_Service_Dataflow_AutoscalingSettings';
    protected $autoscalingSettingsDataType = '';
    protected $dataDisksType = 'Google_Service_Dataflow_Disk';
    protected $dataDisksDataType = 'array';
  protected $packagesType = 'Google_Service_Dataflow_Package';
  protected $packagesDataType = 'array';
  protected $taskrunnerSettingsType = 'Google_Service_Dataflow_TaskRunnerSettings';
  protected $taskrunnerSettingsDataType = '';

  public function setAutoscalingSettings(Google_Service_Dataflow_AutoscalingSettings $autoscalingSettings)
  {
    $this->autoscalingSettings = $autoscalingSettings;
  }
  public function getAutoscalingSettings()
  {
    return $this->autoscalingSettings;
  }
  public function setDataDisks($dataDisks)
  {
    $this->dataDisks = $dataDisks;
  }
  public function getDataDisks()
  {
    return $this->dataDisks;
  }

    public function getDefaultPackageSet()
  {
    return $this->defaultPackageSet;
  }

    public function setDefaultPackageSet($defaultPackageSet)
  {
      $this->defaultPackageSet = $defaultPackageSet;
  }

    public function getDiskSizeGb()
  {
    return $this->diskSizeGb;
  }

    public function setDiskSizeGb($diskSizeGb)
  {
      $this->diskSizeGb = $diskSizeGb;
  }

    public function getDiskSourceImage()
  {
    return $this->diskSourceImage;
  }

    public function setDiskSourceImage($diskSourceImage)
  {
      $this->diskSourceImage = $diskSourceImage;
  }

    public function getKind()
  {
    return $this->kind;
  }

    public function setKind($kind)
  {
      $this->kind = $kind;
  }

    public function getMachineType()
  {
    return $this->machineType;
  }

    public function setMachineType($machineType)
  {
      $this->machineType = $machineType;
  }

    public function getMetadata()
  {
    return $this->metadata;
  }

    public function setMetadata($metadata)
  {
      $this->metadata = $metadata;
  }

    public function getNumWorkers()
  {
    return $this->numWorkers;
  }

    public function setNumWorkers($numWorkers)
  {
      $this->numWorkers = $numWorkers;
  }

    public function getOnHostMaintenance()
  {
    return $this->onHostMaintenance;
  }

    public function setOnHostMaintenance($onHostMaintenance)
    {
        $this->onHostMaintenance = $onHostMaintenance;
    }

  public function setPackages($packages)
  {
    $this->packages = $packages;
  }
  public function getPackages()
  {
    return $this->packages;
  }
  public function setTaskrunnerSettings(Google_Service_Dataflow_TaskRunnerSettings $taskrunnerSettings)
  {
    $this->taskrunnerSettings = $taskrunnerSettings;
  }
  public function getTaskrunnerSettings()
  {
    return $this->taskrunnerSettings;
  }

    public function getTeardownPolicy()
  {
    return $this->teardownPolicy;
  }

    public function setTeardownPolicy($teardownPolicy)
  {
      $this->teardownPolicy = $teardownPolicy;
  }

    public function getZone()
  {
    return $this->zone;
  }

    public function setZone($zone)
    {
        $this->zone = $zone;
    }
}

class Google_Service_Dataflow_WorkerPoolMetadata extends Google_Model
{
}

class Google_Service_Dataflow_WorkerSettings extends Google_Model
{
  public $baseUrl;
  public $reportingEnabled;
  public $servicePath;
  public $shuffleServicePath;
  public $tempStoragePrefix;
  public $workerId;
    protected $internal_gapi_mappings = array();

  public function getBaseUrl()
  {
    return $this->baseUrl;
  }

    public function setBaseUrl($baseUrl)
  {
      $this->baseUrl = $baseUrl;
  }

    public function getReportingEnabled()
  {
    return $this->reportingEnabled;
  }

    public function setReportingEnabled($reportingEnabled)
  {
      $this->reportingEnabled = $reportingEnabled;
  }

    public function getServicePath()
  {
    return $this->servicePath;
  }

    public function setServicePath($servicePath)
  {
      $this->servicePath = $servicePath;
  }

    public function getShuffleServicePath()
  {
    return $this->shuffleServicePath;
  }

    public function setShuffleServicePath($shuffleServicePath)
  {
      $this->shuffleServicePath = $shuffleServicePath;
  }

    public function getTempStoragePrefix()
  {
    return $this->tempStoragePrefix;
  }

    public function setTempStoragePrefix($tempStoragePrefix)
  {
      $this->tempStoragePrefix = $tempStoragePrefix;
  }

    public function getWorkerId()
  {
    return $this->workerId;
  }

    public function setWorkerId($workerId)
    {
        $this->workerId = $workerId;
    }
}

class Google_Service_Dataflow_WriteInstruction extends Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $inputType = 'Google_Service_Dataflow_InstructionInput';
  protected $inputDataType = '';
  protected $sinkType = 'Google_Service_Dataflow_Sink';
  protected $sinkDataType = '';


  public function setInput(Google_Service_Dataflow_InstructionInput $input)
  {
    $this->input = $input;
  }
  public function getInput()
  {
    return $this->input;
  }
  public function setSink(Google_Service_Dataflow_Sink $sink)
  {
    $this->sink = $sink;
  }
  public function getSink()
  {
    return $this->sink;
  }
}
