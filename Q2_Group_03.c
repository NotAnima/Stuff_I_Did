#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <unistd.h>
#include "datastructures.h"

#define timeQuantum 2
#define BUFFER_SIZE 1024
#define MAXJOBS 6
#define ganttSize 64
#define sharedArrivals 3
#define sharedBursts 3
#define sharedPriorities 2
#define TIMEUNIT 1
#define NUMBEROFALGOS 5

/************************************************************/
/*                                                          */
/*  To compile: gcc -o Q2 Q2_Group_03.c datastructures.c    */
/*                                                          */
/************************************************************/

/* function declarations */
int handleFCFS(node *jobQueue[], int size);
int handleSJF(node *jobQueue[], int size);
int handleSRTF(node *jobQueue[], int size);
int handleRR(node *jobQueue[], int size);
int handlePriority(node *jobQueue[], int size, int preemptiveChoice);

int runFCFS(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess);
int runSJF(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess);
int runSRTF(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess);
int runRR(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess);
int runPriority(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess);
int runNPPriority(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess);

/* global variables start */

int validJobs = 0; // initially assumes it is not a valid job queue
int elapsedTime = 0;
int emergencyBreak = 0;

ganttStruct *ganttOrder[ganttSize] = {NULL};
ganttStruct *ganttBlocks[ganttSize] = {NULL};

winner *winnerArray[NUMBEROFALGOS] = {NULL};

linkerHead *readyQueue;
linkerHead *executingProcess;

int choice = 0;
int preemptiveChoice = 0;

/* global variables end */

int main(int argc, char *argv[])
{
  char filename[] = "Q2_Group_03.txt";
  if (access(filename, F_OK) != -1) {
        if (remove(filename) == 0) {
        } else {
        }
    } else {
    }
    
  //the above code just removes the .txt file makes it neat

  printf("\n");

  srand(time(NULL));
  while(choice <= 0 || choice >= 6)
  {
    choice = get_choice();
  }
  node *jobQueue[MAXJOBS] = {NULL};
  int preemptiveChoice = 0;
  char text[BUFFER_SIZE];
  while(preemptiveChoice < 1 || preemptiveChoice > 2)
  {
    preemptiveChoice = getPreempChoice();
  }


  char preemptionMsg[BUFFER_SIZE] = " ";
  char choiceOfAlgorithm[BUFFER_SIZE] = " ";

  if (choice == 1)
  {
    sprintf(choiceOfAlgorithm, "%s", "First Come First Serve");
    while (!validJobs || !isAscending(jobQueue, choice))
    {
        validJobs = 0;
        makeJobsForFCFS(jobQueue, &validJobs, &emergencyBreak);
    }
  }

  else if(choice == 2)
  {
    sprintf(choiceOfAlgorithm, "%s", "Shortest Job First");
    while (!validJobs)
    {
        makeJobsForSJF(jobQueue, &validJobs, &emergencyBreak, ganttOrder, ganttBlocks);
    }
  }

  else if(choice == 3)
  {
    sprintf(choiceOfAlgorithm, "%s", "Shortest Remaining Time First");
    while (!validJobs)
    {
        makeJobs(jobQueue, &validJobs, &emergencyBreak);
    }
  }

  else if(choice == 4)
  {
    sprintf(choiceOfAlgorithm, "%s", "Round Robin");
    while (!validJobs)
    {
        makeJobs(jobQueue, &validJobs, &emergencyBreak);
    }
  }

  else
  {
    sprintf(choiceOfAlgorithm, "%s", "Priority");
    while ((!validJobs || !isAscending(jobQueue, choice)) && preemptiveChoice == 1)
    {
        validJobs = 0;
        makeJobsForPriority(jobQueue, &validJobs, &emergencyBreak, ganttOrder, ganttBlocks);
    }
    while((!validJobs || !isAscending(jobQueue, choice)) && preemptiveChoice == 2)
    {
        validJobs = 0;
        makeJobsForPriority(jobQueue, &validJobs, &emergencyBreak, ganttOrder, ganttBlocks);
    }
  }

  send_to_file(choiceOfAlgorithm);

  if (preemptiveChoice == 1)
  {
    sprintf(preemptionMsg, "Your Priority Scheduling Preemption choice is: True");
    send_to_file(preemptionMsg);
  }

  else
  {
    sprintf(preemptionMsg, "Your Priority Scheduling Preemption choice is: False");
    send_to_file(preemptionMsg);
  }
  

  normalizeData(jobQueue);
  char initializerMsg[] = "These are the properties of the nodes before it's being processed by the Algorithms\n";
  send_to_file(initializerMsg);
  mergeSortByPid(jobQueue, MAXJOBS);

  drawTable(jobQueue);
  
  char everythingAfterIsProcessed[] = "\nEverything after this line is processed by scheduling Algorithms\n";
  send_to_file(everythingAfterIsProcessed);

  if (choice == 1)
  {

    sortForFCFS(jobQueue, MAXJOBS);
    handleFCFS(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleSJF(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleSRTF(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleRR(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handlePriority(jobQueue, MAXJOBS, preemptiveChoice);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    //for (int i = 0; i < MAXJOBS; i++){getNodeProperties(jobQueue[i]);} //this is to check for whether processes are actually resetted in the .txt file
  }

  else if (choice == 2)
  {

    handleSJF(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleFCFS(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleSRTF(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleRR(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handlePriority(jobQueue, MAXJOBS, preemptiveChoice);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);
  }

  else if (choice == 3)
  {

    handleSRTF(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleFCFS(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleSJF(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleRR(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handlePriority(jobQueue, MAXJOBS, preemptiveChoice);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);
  }

  else if (choice == 4)
  {

    handleRR(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleFCFS(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleSJF(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleSRTF(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handlePriority(jobQueue, MAXJOBS, preemptiveChoice);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

  }

  else
  {

    handlePriority(jobQueue, MAXJOBS, preemptiveChoice);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleFCFS(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleSJF(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleSRTF(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    handleRR(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

  }
  
  didIWin(winnerArray, choice);

  // destroying to free up memory
  destroyJobQueue(jobQueue);
  destroyGanttArray(ganttOrder);


  return 0;
}

int handleFCFS(node *jobQueue[], int size)
{

  readyQueue = (linkerHead *)malloc(sizeof(linkerHead));

  readyQueue->head = NULL;

  readyQueue->tail = NULL;

  executingProcess = (linkerHead *)malloc(sizeof(linkerHead));

  executingProcess->head = NULL;

  executingProcess->tail = NULL;

  runFCFS(jobQueue, size, readyQueue, executingProcess);

  free(readyQueue);
  free(executingProcess);

  return 0;
}

int runFCFS(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess)
{

  node* readyArr[MAXJOBS] = {NULL}; //init to all NULL
  elapsedTime = 0; //set the elapsedTime to be 0 for the universal CPU execution time
  int processesCompleted = 0;
  int totalTurnAroundTime = 0;
  int totalWaitingTime = 0;
  int totalResponseTime = 0;

  while(processesCompleted < MAXJOBS)
  {   

      placeArrivedJobs(jobQueue, readyArr, elapsedTime); //continuously places jobs into a readyArray
      sortForFCFS(readyArr, MAXJOBS); //sort the readyArray to be for FCFS
      placeJobs(readyArr, readyLinkedList, size); //the readyLinkedList->tail should be the front most node in the queue to be executed by the CPU

      executingProcess->head = readyLinkedList->tail; 
      
      node* selectedProcess = executingProcess->head; //the process to execute for this specific loop is the last item in the readyLinkedList

      while(selectedProcess->timeLeft == 0)
      {
        selectedProcess = selectedProcess->prevPtr; //get the node that hasn't been finished yet
      }
      
      node *thisProcess = selectedProcess;

      thisProcess->responseTime = elapsedTime - thisProcess->arrivalTime; //the time that has already been spent by the CPU executing processes minus off the arrival time of this process

      //retrieving process information to process it by the scheduler
      int burstTime = thisProcess -> burstTime;

      elapsedTime += burstTime;
      thisProcess->timeLeft = 0; // the job should just finish

      //setting the process's times to the formulas
      thisProcess->turnAroundTime = elapsedTime - (thisProcess->arrivalTime);
      thisProcess->waitingTime = (thisProcess->turnAroundTime) - burstTime;

      //this writes out the process' turnAroundTime etc etc into the txt file
      //getNodeProperties(thisProcess);

      //updating the total times to calculate the averages of later on
      totalTurnAroundTime += thisProcess->turnAroundTime;
      totalWaitingTime += thisProcess->waitingTime;
      totalResponseTime += thisProcess->responseTime;
      processesCompleted += 1;
      
      insertIntoGanttOrder(thisProcess, ganttOrder, elapsedTime);
  }
  
  //after it exits the loop after completing all the processes
  char schedulingType[] = "FCFS";

  getGanttBlocks(ganttOrder, ganttBlocks, schedulingType);
  writeGanttChart(ganttBlocks, schedulingType);

  calculateAverageTimes(readyArr, schedulingType, winnerArray);

  printf("Total Time elapsed After all processes finished in FCFS: %d\n\n", elapsedTime);

  return 0;
}

int handleSJF(node *jobQueue[], int size)
{
  readyQueue = (linkerHead *)malloc(sizeof(linkerHead));

  readyQueue->head = NULL;

  readyQueue->tail = NULL;

  executingProcess = (linkerHead *)malloc(sizeof(linkerHead));

  executingProcess->head = NULL;

  executingProcess->tail = NULL;

  runSJF(jobQueue, size, readyQueue, executingProcess);

  free(readyQueue);
  free(executingProcess);

  return 0;
}

int runSJF(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess)
{
  node* readyArr[MAXJOBS] = {NULL}; //init to all NULL
  elapsedTime = 0; //set the elapsedTime to be 0 for the universal CPU execution time
  int processesCompleted = 0;
  int totalTurnAroundTime = 0;
  int totalWaitingTime = 0;
  int totalResponseTime = 0;
  while(processesCompleted < MAXJOBS)
  {   
      placeArrivedJobs(jobQueue, readyArr, elapsedTime); //continuously places jobs into a readyArray
      sortForSJF(readyArr, MAXJOBS); //sort the readyArray to be for FCFS
      placeJobs(readyArr, readyLinkedList, size); //the readyLinkedList->tail should be the front most node in the queue to be executed by the CPU

      executingProcess->head = readyLinkedList->tail; 
      
      node* selectedProcess = executingProcess->head; //the process to execute for this specific loop is the last item in the readyLinkedList

      while(selectedProcess->timeLeft == 0)
      {
        selectedProcess = selectedProcess->prevPtr; //get the node that hasn't been finished yet
      }
      
      node *thisProcess = selectedProcess;

      if (thisProcess->responseTime == 0)
      {
          thisProcess->responseTime = elapsedTime - thisProcess->arrivalTime; //the time that has already been spent by the CPU executing processes minus off the arrival time of this process
      }

      //retrieving process information to process it by the scheduler
      int burstTime = thisProcess -> burstTime;

      elapsedTime += burstTime;
      thisProcess->timeLeft = 0; // the job should just finish

      //setting the process's times to the formulas
      thisProcess->turnAroundTime = elapsedTime - (thisProcess->arrivalTime);
      thisProcess->waitingTime = (thisProcess->turnAroundTime) - burstTime;

      //getNodeProperties(thisProcess);

      totalTurnAroundTime += thisProcess->turnAroundTime;
      totalWaitingTime += thisProcess->waitingTime;
      totalResponseTime += thisProcess->responseTime;
      processesCompleted += 1;
      insertIntoGanttOrder(thisProcess, ganttOrder, elapsedTime);
  }
  char schedulingType[] = "SJF";

  getGanttBlocks(ganttOrder, ganttBlocks, schedulingType);
  writeGanttChart(ganttBlocks, schedulingType);

  calculateAverageTimes(readyArr, schedulingType, winnerArray);

  printf("Total Time elapsed After all processes finished in SJF: %d\n\n", elapsedTime);

  return 0;
}

int handleSRTF(node *jobQueue[], int size)
{
  readyQueue = (linkerHead *)malloc(sizeof(linkerHead));

  readyQueue->head = NULL;

  readyQueue->tail = NULL;

  executingProcess = (linkerHead *)malloc(sizeof(linkerHead));

  executingProcess->head = NULL;

  executingProcess->tail = NULL;

  runSRTF(jobQueue, size, readyQueue, executingProcess);

  free(readyQueue);
  free(executingProcess);

  return 0;
}

int runSRTF(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess)
{
  node* readyArr[MAXJOBS] = {NULL}; //init to all NULL
  elapsedTime = 0; //set the elapsedTime to be 0 for the universal CPU execution time
  int processesCompleted = 0;
  int totalTurnAroundTime = 0;
  int totalWaitingTime = 0;
  int totalResponseTime = 0;
  while(processesCompleted < MAXJOBS)
  {   
      placeArrivedJobs(jobQueue, readyArr, elapsedTime); //continuously places jobs into a readyArray
      sortForSRTF(readyArr, MAXJOBS); //sort the readyArray to be for FCFS
      placeJobs(readyArr, readyLinkedList, size); //the readyLinkedList->tail should be the front most node in the queue to be executed by the CPU

      executingProcess->head = readyLinkedList->tail; 
      
      node* selectedProcess = executingProcess->head; //the process to execute for this specific loop is the last item in the readyLinkedList

      while(selectedProcess->timeLeft == 0)
      {
        selectedProcess = selectedProcess->prevPtr; //get the node that hasn't been finished yet
      }
      
      node *thisProcess = selectedProcess;

      if (thisProcess->responseTime == 0 && thisProcess->respondedFlag == 0)
      {
          thisProcess->respondedFlag = 1;
          thisProcess->responseTime = elapsedTime - thisProcess->arrivalTime; //the time that has already been spent by the CPU executing processes minus off the arrival time of this process
      }

      //retrieving process information to process it by the scheduler
      int burstTime = thisProcess -> burstTime;


      elapsedTime += TIMEUNIT;
      thisProcess->timeLeft -= TIMEUNIT; // the TIMEUNIT separates the loop out into slices of the ganntchart so that it can continuously check if it needs to be preempted out

      //setting the process's times to the formulas
      if (thisProcess->timeLeft == 0)
      {
        thisProcess->turnAroundTime = elapsedTime - (thisProcess->arrivalTime);
       
        thisProcess->waitingTime = (thisProcess->turnAroundTime) - burstTime;

        //this writes out the process' turnAroundTime etc etc into the txt file
        //getNodeProperties(thisProcess);

        processesCompleted += 1;
      }

      insertIntoGanttOrder(thisProcess, ganttOrder, elapsedTime);

  }

  char schedulingType[] = "SRTF";

  getGanttBlocks(ganttOrder, ganttBlocks, schedulingType);
  writeGanttChart(ganttBlocks, schedulingType);

  calculateAverageTimes(readyArr, schedulingType, winnerArray);

  printf("Total Time elapsed After all processes finished in SRTF: %d\n\n", elapsedTime);
  return 0;
}

int handleRR(node *jobQueue[], int size)
{
  readyQueue = (linkerHead *)malloc(sizeof(linkerHead));

  readyQueue->head = NULL;

  readyQueue->tail = NULL;

  executingProcess = (linkerHead *)malloc(sizeof(linkerHead));

  executingProcess->head = NULL;

  executingProcess->tail = NULL;

  runRR(jobQueue, size, readyQueue, executingProcess);

  free(readyQueue);
  free(executingProcess);

  return 0;
}

int runRR(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess)
{
  node* readyArr[MAXJOBS] = {NULL}; //init to all NULL
  elapsedTime = 0; //set the elapsedTime to be 0 for the universal CPU execution time
  int processesCompleted = 0;
  int totalTurnAroundTime = 0;
  int totalWaitingTime = 0;
  int totalResponseTime = 0;
  int indexToSelect = 0;
  int lastProcessSelected = 0;
  sortForFCFS(jobQueue, MAXJOBS);
  node* thisProcess;
  while(processesCompleted < MAXJOBS)
  {
      lastProcessSelected = indexToSelect;
      placeArrivedJobs(jobQueue, readyArr, elapsedTime);
      for (int i = 0; i < MAXJOBS; i++)
      {
          if(allAreEmpty(readyArr, MAXJOBS))
          {
            break;
          }

          if(readyArr[i] == NULL)
          {
            continue;
          }

          if(readyArr[i] -> timeLeft == 0)
          {
            continue;
          }

          thisProcess = readyArr[i];

          if (thisProcess->responseTime == 0 && thisProcess->respondedFlag == 0)
          {

            thisProcess->respondedFlag = 1;

            thisProcess->responseTime = elapsedTime - thisProcess->arrivalTime; //the time that has already been spent by the CPU executing processes minus off the arrival time of this process

          }

          int burstTime = thisProcess->burstTime;

          if(thisProcess->timeLeft < timeQuantum)
          {
            elapsedTime += 1;
            thisProcess->timeLeft -= 1;
          }

          else
          {
            elapsedTime += timeQuantum;
            thisProcess->timeLeft -= timeQuantum;
          }

          placeArrivedJobs(jobQueue, readyArr, elapsedTime);

          if (thisProcess->timeLeft == 0)
          {

            thisProcess->turnAroundTime = elapsedTime - (thisProcess->arrivalTime);

            thisProcess->waitingTime = (thisProcess->turnAroundTime) - burstTime;

            //this writes out the process' turnAroundTime etc etc into the txt file
            //getNodeProperties(thisProcess);

            processesCompleted += 1;

          }

          insertIntoGanttOrder(thisProcess, ganttOrder, elapsedTime);

      }

  }

  char schedulingType[] = "RR";

  getGanttBlocks(ganttOrder, ganttBlocks, schedulingType);

  writeGanttChart(ganttBlocks, schedulingType);

  calculateAverageTimes(readyArr, schedulingType, winnerArray);

  printf("Total Time elapsed After all processes finished in RR: %d\n\n", elapsedTime);
  return 0;

}

int handlePriority(node *jobQueue[], int size, int preemptiveChoice)
{
  readyQueue = (linkerHead *)malloc(sizeof(linkerHead));

  readyQueue->head = NULL;

  readyQueue->tail = NULL;

  executingProcess = (linkerHead *)malloc(sizeof(linkerHead));

  executingProcess->head = NULL;

  executingProcess->tail = NULL;

  if(preemptiveChoice == 1)
  {
    runPriority(jobQueue, size, readyQueue, executingProcess);
  }

  else if(preemptiveChoice == 2)
  {
    runNPPriority(jobQueue, size, readyQueue, executingProcess);
  }

  free(readyQueue);
  free(executingProcess);

  return 0;
}

int runPriority(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess)
{
  node* readyArr[MAXJOBS] = {NULL}; //init to all NULL
  elapsedTime = 0; //set the elapsedTime to be 0 for the universal CPU execution time
  int processesCompleted = 0;
  int totalTurnAroundTime = 0;
  int totalWaitingTime = 0;
  int totalResponseTime = 0;

  while(processesCompleted < MAXJOBS)
  {   
      placeArrivedJobs(jobQueue, readyArr, elapsedTime); //continuously places jobs into a readyArray
      sortForPriority(readyArr, MAXJOBS); //sort the readyArray to be for FCFS
      placeJobs(readyArr, readyLinkedList, size); //the readyLinkedList->tail should be the front most node in the queue to be executed by the CPU

      executingProcess->head = readyLinkedList->tail; 
      
      node* selectedProcess = executingProcess->head; //the process to execute for this specific loop is the last item in the readyLinkedList

      while(selectedProcess->timeLeft == 0)
      {
        selectedProcess = selectedProcess->prevPtr; //get the node that hasn't been finished yet
      }
      
      node *thisProcess = selectedProcess;

      if (thisProcess->responseTime == 0 && thisProcess->respondedFlag == 0)
      {
          thisProcess->respondedFlag = 1;
          thisProcess->responseTime = elapsedTime - thisProcess->arrivalTime; //the time that has already been spent by the CPU executing processes minus off the arrival time of this process
      }

      //retrieving process information to process it by the scheduler
      int burstTime = thisProcess -> burstTime;

      elapsedTime += TIMEUNIT;
      thisProcess->timeLeft -= TIMEUNIT; // the TIMEUNIT separates the loop out into slices of the ganntchart so that it can continuously check if it needs to be preempted out

      //setting the process's times to the formulas
      if (thisProcess->timeLeft == 0)
      {
        thisProcess->turnAroundTime = elapsedTime - (thisProcess->arrivalTime);

        thisProcess->waitingTime = (thisProcess->turnAroundTime) - burstTime;

        //this writes out the process' turnAroundTime etc etc into the txt file
        //getNodeProperties(thisProcess);

        processesCompleted += 1;

      }

      //updating the total times to calculate the averages of later on
      insertIntoGanttOrder(thisProcess, ganttOrder, elapsedTime);
  }
  
  char schedulingType[] = "Priority";

  getGanttBlocks(ganttOrder, ganttBlocks, schedulingType);
  writeGanttChart(ganttBlocks, schedulingType);
  
  calculateAverageTimes(readyArr, schedulingType, winnerArray);

  printf("Total Time elapsed After all processes finished in Priority: %d\n\n", elapsedTime);
  return 0;
}

int runNPPriority(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess)
{
  node* readyArr[MAXJOBS] = {NULL}; //init to all NULL
  elapsedTime = 0; //set the elapsedTime to be 0 for the universal CPU execution time
  int processesCompleted = 0;
  int totalTurnAroundTime = 0;
  int totalWaitingTime = 0;
  int totalResponseTime = 0;

  while(processesCompleted < MAXJOBS)
  {   

      placeArrivedJobs(jobQueue, readyArr, elapsedTime); //continuously places jobs into a readyArray
      sortForPriority(readyArr, MAXJOBS); //sort the readyArray to be for FCFS
      placeJobs(readyArr, readyLinkedList, size); //the readyLinkedList->tail should be the front most node in the queue to be executed by the CPU

      executingProcess->head = readyLinkedList->tail; 
      
      node* selectedProcess = executingProcess->head; //the process to execute for this specific loop is the last item in the readyLinkedList

      while(selectedProcess->timeLeft == 0)
      {
        selectedProcess = selectedProcess->prevPtr; //get the node that hasn't been finished yet
      }
      
      node *thisProcess = selectedProcess;

      thisProcess->responseTime = elapsedTime - thisProcess->arrivalTime; //the time that has already been spent by the CPU executing processes minus off the arrival time of this process

      int burstTime = thisProcess -> burstTime;

      elapsedTime += burstTime;
      thisProcess->timeLeft = 0; // the job should just finish

      //setting the process's times to the formulas
      thisProcess->turnAroundTime = elapsedTime - (thisProcess->arrivalTime);
      thisProcess->waitingTime = (thisProcess->turnAroundTime) - burstTime;

      //this writes out the process' turnAroundTime etc etc into the txt file
      //getNodeProperties(thisProcess);

      //updating the total times to calculate the averages of later on
      totalTurnAroundTime += thisProcess->turnAroundTime;
      totalWaitingTime += thisProcess->waitingTime;
      totalResponseTime += thisProcess->responseTime;
      processesCompleted += 1;
      insertIntoGanttOrder(thisProcess, ganttOrder, elapsedTime);
  }

  //after it exits the loop after completing all the processes
  char schedulingType[] = "Priority";

  getGanttBlocks(ganttOrder, ganttBlocks, schedulingType);
  writeGanttChart(ganttBlocks, schedulingType);

  calculateAverageTimes(readyArr, schedulingType, winnerArray);

  printf("Total Time elapsed After all processes finished in Priority: %d\n\n", elapsedTime);

  return 0;
}

